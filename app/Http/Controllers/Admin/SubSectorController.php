<?php

namespace App\Http\Controllers\Admin;

use AllowDynamicProperties;
use App\Http\Controllers\Controller;
use App\Models\Society;
use App\Models\SubSector;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

#[AllowDynamicProperties]
class SubSectorController extends Controller
{
    protected AiService $seoService;

    /**
     * Inject the AI SEO service.
     *
     * @param AiService $seoService
     */
    public function __construct(AiService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Display a listing of all sub‐sectors.
     * AJAX → JSON; otherwise → Blade.
     *
     * @param Request $request
     * @return View|JsonResponse
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = SubSector::with(['society', 'parent', 'children'])->latest();

        if ($request->ajax()) {
            $subs = $query->get();
            return response()->json(['data' => $subs], 200);
        }

        $subSectors = $query->paginate(50);
        return view('admin.subsectors.index', compact('subSectors'));
    }

    /**
     * Show the form for creating a new sub‐sector.
     *
     * @return View
     */
    public function create(): View
    {
        $societies    = Society::all();
        $allSubSectors = SubSector::all(); // for parent‐selection
        return view('admin.subsectors.create', compact('societies','allSubSectors'));
    }

    /**
     * Store a newly created sub‐sector.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'society_id'     => ['required','exists:societies,id'],
            'parent_id'      => ['nullable','exists:sub_sectors,id'],
            'name'           => ['required','string','max:255'],
            'title'          => ['nullable','string','max:255'],
            'slug'           => ['nullable','string','max:255','unique:sub_sectors,slug'],
            'meta_keywords'  => ['nullable','string'],
            'meta_detail'    => ['nullable','string'],
            'detail'         => ['nullable','string'],
            'block'          => ['nullable','string','max:50'],
            'image'          => ['nullable','image','max:10240'],
        ]);

        return DB::transaction(function() use($validated, $request) {
            // Optional: regenerate SEO metadata
             $seo = $this->seoService->generate($validated['name'], Society::find($validated['society_id'])->name);

            // Create subSector record
            $subSector = SubSector::create([
                'society_id'    => $validated['society_id'],
                'parent_id'     => $validated['parent_id'] ?? null,
                'name'          => $validated['name'],
                'title'         => $validated['title'] ?? null,
                'slug'          => $validated['slug'] ?? Str::slug($validated['name']),
                'meta_keywords' => $validated['meta_keywords'] ?? null,
                'meta_detail'   => $validated['meta_detail'] ?? null,
                'detail'        => $validated['detail'] ?? null,
                'block'         => $validated['block'] ?? null,
            ]);

            // Handle image upload (responsive variants)
            if ($file = $request->file('image')) {
                $this->uploadImage($subSector, $file);
            }

            return response()->json([
                'message'   => 'Sub‐sector created successfully.',
                'subSector' => $subSector->load(['society','parent','children']),
            ], 201);
        });
    }

    /**
     * Display a single sub‐sector.
     * AJAX → JSON; otherwise → Blade.
     *
     * @param int $id
     * @param Request $request
     * @return View|JsonResponse
     */
    public function show(int $id, Request $request): View|JsonResponse
    {
        $subSector = SubSector::with(['society','parent','children'])->findOrFail($id);

        if ($request->ajax()) {
            return response()->json($subSector, 200);
        }

        return view('admin.subsectors.show', compact('subSector'));
    }

    /**
     * Show the form for editing the specified sub‐sector.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $subSector           = SubSector::findOrFail($id);
        $societies     = Society::all();
        // Exclude self from parent selection
        $allSubSectors = SubSector::where('id','!=',$id)->get();

        return view('admin.subsectors.edit', compact('subSector','societies','allSubSectors'));
    }

    /**
     * Update the specified sub‐sector.
     *
     * @param Request $request
     * @param int     $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $subSector = SubSector::findOrFail($id);

        $validated = $request->validate([
            'society_id'    => ['required','exists:societies,id'],
            'parent_id'     => ['nullable','exists:sub_sectors,id'],
            'name'           => ['required','string','max:255'],
            'title'          => ['nullable','string','max:255'],
            'slug'           => ['nullable','string','max:255', Rule::unique('sub_sectors','slug')->ignore($id)],
            'meta_keywords'  => ['nullable','string'],
            'meta_detail'    => ['nullable','string'],
            'detail'         => ['nullable','string'],
            'block'          => ['nullable','string','max:50'],
            'image'          => ['nullable','image','max:10240'],
        ]);

        return DB::transaction(function() use($subSector, $validated, $request) {
            // Update fields
            $subSector->update([
                'society_id'    => $validated['society_id'],
                'parent_id'     => $validated['parent_id'] ?? null,
                'name'          => $validated['name'],
                'title'         => $validated['title'] ?? null,
                'slug'          => $validated['slug'] ?? Str::slug($validated['name']),
                'meta_keywords' => $validated['meta_keywords'] ?? null,
                'meta_detail'   => $validated['meta_detail'] ?? null,
                'detail'        => $validated['detail'] ?? null,
                'block'         => $validated['block'] ?? null,
            ]);

            // Replace image if provided
            if ($file = $request->file('image')) {
                $subSector->clearMediaCollection('sub_sector_image');
                $this->uploadImage($subSector, $file);
            }

            return response()->json([
                'message'   => 'Sub‐sector updated successfully.',
                'subSector' => $subSector->load(['society','parent','children']),
            ], 200);
        });
    }

    /**
     * Remove the specified sub‐sector.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $subSector = SubSector::findOrFail($id);
        $subSector->delete();

        return response()->json([
            'message' => 'Sub‐sector deleted successfully.',
        ], 200);
    }

    /**
     * Restore a soft-deleted Society.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        SubSector::withTrashed()->findOrFail($id)->restore();
        return response()->json(['message'=>'SubSector restored successfully.']);
    }

    /**
     * Upload a responsive image for this SubSector.
     *
     * @param SubSector     $subSector
     * @param UploadedFile  $file
     * @return void
     */
    private function uploadImage(SubSector $subSector, UploadedFile $file): void
    {
        try {
            $subSector
                ->addMedia($file)
                ->usingName(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                ->usingFileName(now()->format('Ymd') . '-' . Str::random(6) . '.' . $file->getClientOriginalExtension())
                ->withResponsiveImages()
                ->toMediaCollection('sub_sector_image');
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            // optionally log
        }
    }
}
