<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Society;
use App\Models\SubSector;
use App\Models\User;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

/**
 * Class SocietyController
 *
 * Handles CRUD for Society, including:
 * - AI-generated SEO metadata
 * - Top-level image uploads (with responsive conversions)
 * - Property-type flags & meta
 * - SubSector persistence in its own table
 *
 * @package App\Http\Controllers\Admin
 */
class SocietyController extends Controller
{
    /**
     * Inject the AI SEO service.
     *
     * @param AiService $seoService
     */
    public function __construct(
        protected AiService $seoService
    ) {}

    /**
     * Display a listing of societies.
     * - AJAX → JSON payload with filters
     * - Otherwise → Blade view
     *
     * @param Request $request
     * @return View|JsonResponse
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Society::with('city')
                ->when($request->filled('status') && in_array($request->status, ['enabled','disabled']),
                    fn($q) => $q->where('status', $request->status)
                )
                ->when($request->filled('search'),
                    fn($q) => $q->where('name', 'ILIKE', "%{$request->search}%")
                )
                ->latest();

            $perPage = $request->input('per_page', 50);
            if ($perPage === 'all' || $perPage > 1000) {
                $all = $query->get();
                return response()->json([
                    'data'  => $all,
                    'links' => [],
                    'meta'  => ['total' => $all->count()],
                ]);
            }

            $p = $query->paginate($perPage);
            return response()->json([
                'data'  => $p->items(),
                'links' => $p->linkCollection()->toArray(),
                'meta'  => [
                    'current_page' => $p->currentPage(),
                    'last_page'    => $p->lastPage(),
                    'total'        => $p->total(),
                ],
            ]);
        }

        return view('admin.societies.index');
    }

    /**
     * Show form for creating a new Society.
     *
     * @return View
     */
    public function create(): View
    {
        $cities = City::all();
        $users  = User::all();

        return view('admin.societies.create', compact('cities','users'));
    }

    /**
     * Store a newly created Society.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'            => ['required','string','max:255'],
            'slug'            => ['required','string','max:255','unique:societies,slug'],
            'city_id'         => ['required','exists:cities,id'],
            'user_id'         => ['required','exists:users,id'],
            'overview'        => ['nullable','string'],
            'detail'          => ['nullable','string'],
            'status'          => ['required','in:enabled,disabled'],
            'society_image'   => ['nullable','image','max:10240'],
            'banner'          => ['nullable','image','max:10240'],
            'has_sub_sectors' => ['nullable','in:Y,N'],
            'sub_sectors'     => ['nullable','array'],
            'sub_sectors.*.name'         => ['nullable','string','max:255'],
            'sub_sectors.*.title'        => ['nullable','string','max:255'],
            'sub_sectors.*.slug'         => ['nullable','string','max:255'],
            'sub_sectors.*.meta_keywords'=> ['nullable','string'],
            'sub_sectors.*.meta_detail'  => ['nullable','string'],
            'sub_sectors.*.detail'       => ['nullable','string'],
            'sub_sectors.*.block'        => ['nullable','string','max:20'],
            'sub_sectors.*.image'        => ['nullable','image','max:10240'],
        ]);

        DB::beginTransaction();

        try {
            // Generate SEO metadata using AI service
            $cityName = City::findOrFail($validated['city_id'])->name;
            $seo      = $this->seoService->generate($validated['name'], $cityName);

            // Create Society core record
            $society = Society::create([
                'name'            => $validated['name'],
                'slug'            => $validated['slug'],
                'city_id'         => $validated['city_id'],
                'user_id'         => $validated['user_id'],
                'overview'        => $validated['overview'],
                'detail'          => $validated['detail'],
                'status'          => $validated['status'],
                'seo_title'       => $seo['seo_title'],
                'seo_description' => $seo['seo_description'],
                'seo_keywords'    => $seo['seo_keywords'],
                'created_by'      => auth()->id() ?: 1,
            ]);

            // Handle top-level images & property types
            $this->updateTopLevelImages($society, $request);

            // Persist each SubSector in its own table
            if ($request->input('has_sub_sectors') === 'Y') {
                foreach ($request->sub_sectors as $idx => $data) {
                    /** @var SubSector $sub */
                    $sub = SubSector::create([
                        'society_id'    => $society->id,
                        'parent_id'     => null,
                        'type'          => 'subsector',
                        'name'          => $data['name']         ?? null,
                        'slug'          => $data['slug']         ?? null,
                        'title'         => $data['title']        ?? null,
                        'meta_keywords' => $data['meta_keywords']?? null,
                        'meta_detail'   => $data['meta_detail']  ?? null,
                        'detail'        => $data['detail']       ?? null,
                        'block'         => $data['block']        ?? null,
                    ]);

                    if ($file = $request->file("sub_sectors.{$idx}.image")) {
                        $this->uploadSubSectorImage($sub, $file);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Society created successfully.',
                'data'    => $society,
            ], 201);

        } catch (Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'message' => 'Failed to create society.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified Society.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $society      = Society::with('subSectors')->findOrFail($id);
        $cities       = City::all();
        $users        = User::all();
        $flags        = ['residential_plots','commercial_plots','houses','apartments','farm_houses','shop'];
        $savedMeta    = $society->property_types ?? [];
        $propertyMeta = [];

        foreach ($flags as $type) {
            $propertyMeta[$type] = [
                'title'       => $savedMeta[$type]['title']       ?? '',
                'keywords'    => $savedMeta[$type]['keywords']    ?? '',
                'description' => $savedMeta[$type]['description'] ?? '',
            ];
        }

        // Prepare payload for Alpine.js
        $jsData = [
            'name'          => $society->name,
            'slug'          => $society->slug,
            'overview'      => $society->overview,
            'detail'        => $society->detail,
            'city_id'       => $society->city_id,
            'user_id'       => $society->user_id,
            'imageUrls'     => [
                'society_image' => $society->getFirstMediaUrl('society_image'),
                'banner'        => $society->getFirstMediaUrl('banner'),
            ],
            'enabled'       => $society->status === 'enabled',
            'types'         => collect($flags)
                ->mapWithKeys(fn($t) => [$t => (bool)$society->{"has_{$t}"}])
                ->all(),
            'hasSubSectors' => $society->subSectors->isNotEmpty(),
            'subSectors'    => $society->subSectors->map(fn($s) => [
                'id'            => $s->id,
                'name'          => $s->name,
                'title'         => $s->title,
                'slug'          => $s->slug,
                'meta_keywords' => $s->meta_keywords,
                'meta_detail'   => $s->meta_detail,
                'detail'        => $s->detail,
                'block'         => $s->block,
                'image_url'     => $s->getFirstMediaUrl('sub_sector_image'),
            ])->all(),
            'propertyMeta'  => $propertyMeta,
        ];

        return view('admin.societies.edit', compact(
            'society','cities','users','flags','jsData'
        ));
    }

    /**
     * Update the specified Society.
     *
     * @param Request $request
     * @param int     $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $society = Society::with('subSectors')->findOrFail($id);

        $validated = $request->validate([
            'name'            => ['required','string','max:255'],
            'slug'            => ['required','string','max:255', Rule::unique('societies','slug')->ignore($id)],
            'city_id'         => ['required','exists:cities,id'],
            'user_id'         => ['required','exists:users,id'],
            'overview'        => ['nullable','string'],
            'detail'          => ['nullable','string'],
            'status'          => ['required','in:enabled,disabled'],
            'society_image'   => ['nullable','image','max:10240'],
            'banner'          => ['nullable','image','max:10240'],
            'has_sub_sectors' => ['nullable','in:Y,N'],
            'sub_sectors'     => ['nullable','array'],
            'sub_sectors.*.id'         => ['nullable','exists:sub_sectors,id'],
            'sub_sectors.*.name'       => ['nullable','string','max:255'],
            'sub_sectors.*.title'      => ['nullable','string','max:255'],
            'sub_sectors.*.slug'       => ['nullable','string','max:255'],
            'sub_sectors.*.meta_keywords'=> ['nullable','string'],
            'sub_sectors.*.meta_detail'  => ['nullable','string'],
            'sub_sectors.*.detail'       => ['nullable','string'],
            'sub_sectors.*.block'        => ['nullable','string','max:20'],
            'sub_sectors.*.image'        => ['nullable','image','max:10240'],
        ]);

        DB::beginTransaction();

        try {
            // Regenerate SEO metadata
            $cityName = City::findOrFail($validated['city_id'])->name;
            $seo      = $this->seoService->generate($validated['name'], $cityName);

            // Update core Society fields
            $society->update([
                'name'            => $validated['name'],
                'slug'            => $validated['slug'],
                'city_id'         => $validated['city_id'],
                'user_id'         => $validated['user_id'],
                'overview'        => $validated['overview'],
                'detail'          => $validated['detail'],
                'status'          => $validated['status'],
                'seo_title'       => $seo['seo_title'],
                'seo_description' => $seo['seo_description'],
                'seo_keywords'    => $seo['seo_keywords'],
            ]);

            // Update images & property-types
            $this->updateTopLevelImages($society, $request);

            // Sync SubSectors:
            //  • delete ones removed
            //  • update existing
            //  • create new
            $incoming = collect($request->input('sub_sectors', []));
            $keepIds  = $incoming->pluck('id')->filter()->all();
            $society->subSectors()->whereNotIn('id', $keepIds)->delete();

            foreach ($incoming as $idx => $data) {
                if (!empty($data['id'])) {
                    $sub = SubSector::findOrFail($data['id']);
                    $sub->update(Arr::except($data, ['image']));
                } else {
                    $sub = SubSector::create([
                        'society_id'    => $society->id,
                        'parent_id'     => null,
                        'type'          => 'subsector',
                        ...Arr::except($data, ['image']),
                    ]);
                }
                if ($file = $request->file("sub_sectors.{$idx}.image")) {
                    $this->uploadSubSectorImage($sub, $file);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Society updated successfully.',
                'data'    => $society->load('subSectors'),
            ]);

        } catch (Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'message' => 'Failed to update society.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a single Society.
     * - AJAX → enriched JSON
     * - Otherwise → Blade view
     *
     * @param int $id
     * @param Request $request
     * @return View|JsonResponse
     */
    public function show(int $id, Request $request): View|JsonResponse
    {
        $society = Society::with(['city','user','subSectors'])->findOrFail($id);

        if ($request->ajax()) {
            $subs = $society->subSectors->map(fn($s) => [
                'id'            => $s->id,
                'name'          => $s->name,
                'slug'          => $s->slug,
                'type'          => $s->type,
                'meta_keywords' => $s->meta_keywords,
                'meta_detail'   => $s->meta_detail,
                'detail'        => $s->detail,
                'block'         => $s->block,
                'image_url'     => $s->getFirstMediaUrl('sub_sector_image'),
            ]);

            return response()->json([
                ...$society->toArray(),
                'main_image_url' => $society->getFirstMediaUrl('society_image'),
                'banner_url'     => $society->getFirstMediaUrl('banner'),
                'sub_sectors'    => $subs,
            ]);
        }

        return view('admin.societies.show', compact('society'));
    }

    /**
     * Soft-delete a Society.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        Society::findOrFail($id)->delete();
        return response()->json(['message'=>'Society soft deleted successfully.']);
    }

    /**
     * Restore a soft-deleted Society.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        Society::withTrashed()->findOrFail($id)->restore();
        return response()->json(['message'=>'Society restored successfully.']);
    }

    /**
     * Upload or replace a top-level image (society_image or banner).
     *
     * @param Society $society
     * @param Request $request
     * @param string  $field      The request key (e.g. 'society_image' or 'banner')
     * @param string  $collection The Spatie media collection name
     */
    private function uploadImage(Society $society, Request $request, string $field, string $collection): void
    {
        if (! $request->hasFile($field)) {
            return;
        }

        $society->clearMediaCollection($collection);
        $file         = $request->file($field);
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension    = $file->getClientOriginalExtension();
        $fileName     = now()->format('Ymd') . '-' . Str::random(6) . '.' . $extension;

        try {
            $society
                ->addMediaFromRequest($field)
                ->usingName($originalName)
                ->usingFileName($fileName)
                ->withResponsiveImages()
                ->toMediaCollection($collection);
        } catch (FileDoesNotExist|FileIsTooBig) {
            // Fail silently, but you could log if desired
        }
    }

    /**
     * Upload or replace a SubSector image.
     *
     * @param SubSector     $sub
     * @param UploadedFile  $file
     */
    private function uploadSubSectorImage(SubSector $sub, UploadedFile $file): void
    {
        $sub->clearMediaCollection('sub_sector_image');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension    = $file->getClientOriginalExtension();
        $fileName     = now()->format('Ymd') . '-' . Str::random(6) . '.' . $extension;

        try {
            $sub
                ->addMedia($file)
                ->usingName($originalName)
                ->usingFileName($fileName)
                ->withResponsiveImages()
                ->toMediaCollection('sub_sector_image');
        } catch (FileDoesNotExist|FileIsTooBig) {
            // Fail silently
        }
    }

    /**
     * Handle both top-level images + property-type flags & meta.
     *
     * @param Society $society
     * @param Request $request
     */
    private function updateTopLevelImages(Society $society, Request $request): void
    {
        // main & banner
        $this->uploadImage($society, $request, 'society_image', 'society_image');
        $this->uploadImage($society, $request, 'banner',        'banner');

        // property-type flags & metadata
        $flags = ['residential_plots','commercial_plots','houses','apartments','farm_houses','shop'];
        $meta  = [];

        foreach ($flags as $type) {
            $has = $request->boolean("has_{$type}");
            $society->{"has_{$type}"} = $has;

            if ($has) {
                $meta[$type] = [
                    'title'       => $request->input("{$type}_title"),
                    'keywords'    => $request->input("{$type}_keywords"),
                    'description' => $request->input("{$type}_description"),
                ];
            }
        }

        $society->property_types = $meta;
        $society->save();
    }
}
