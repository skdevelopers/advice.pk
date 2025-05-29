<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Society;
use App\Models\SubSector;
use App\Models\User;
use App\Services\AiService;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

/**
 * Class PropertyController
 *
 * Manages Property CRUD with AI‐SEO, media uploads, and dynamic features.
 */
class PropertyController extends Controller
{
    /**
     * The AI service instance for SEO.
     *
     * @var AiService
     */
    protected AiService $aiService;

    /**
     * Constructor.
     *
     * @param AiService $aiService
     */
    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Display a paginated list of properties.
     *
     * @return View
     */
    public function index()
    {
        $properties = Property::with('user','society','subsector')->latest()->paginate(10);
        return view('admin.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new property.
     *
     * @return View
     */
    public function create()
    {
        $users          = User::all();
        $societies      = Society::all();
        $subsectors     = SubSector::all();
        $sizes = ['5 Marla', '7 Marla', '10 Marla', '1 Kanal', '2 Kanal'];
        // You must define this array either in config or here
        $featuresConfig = [
            'bedrooms'         => 'Bedrooms',
            'bathrooms'        => 'Bathrooms',
            'garage_capacity'  => 'Garage',
            'drawing_rooms'    => 'Drawing Rooms',
            'kitchens'         => 'Kitchens',
            'study_rooms'      => 'Study Rooms',
            'store_rooms'      => 'Store Rooms',
            'servant_quarters' => 'Servant Quarters',
            'sitting_rooms'    => 'Sitting Rooms',
        ];
        return view('admin.properties.create', compact(
            'users', 'societies', 'subsectors', 'sizes', 'featuresConfig'
        ));
    }

    /**
     * Store a newly created property.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     * @throws Throwable
     */
    public function store(Request $request)
    {
        // 1️⃣ Validate all fields, including uploads and dynamic arrays
        $data = $request->validate([
            'user_id'             => 'required|exists:users,id',
            'society_id'          => 'required|exists:societies,id',
            'sub_sector_id'       => 'nullable|exists:sub_sectors,id',
            'title'               => 'required|string|max:255',
            'slug'                => 'required|string|max:255|unique:properties,slug',
            'purpose'             => 'required|in:sale,rent',
            'property_type'       => 'required|string|max:50',
            'plot_size'           => 'nullable|string|max:100',
            'plot_dimensions'     => 'nullable|string|max:100',
            'price'               => 'nullable|numeric',
            'rent'                => 'nullable|numeric',
            'rent_type'           => 'nullable|in:monthly,yearly',
            'plot_no'             => 'nullable|string|max:50',
            'street'              => 'nullable|string|max:100',
            'location'            => 'nullable|string|max:255',
            'latitude'            => 'nullable|numeric',
            'longitude'           => 'nullable|numeric',
            'description'         => 'nullable|string',
            'keywords'            => 'nullable|string',
            'features'            => 'nullable|array',
            'features.*'          => 'nullable|integer',
            'nearby_facilities'   => 'nullable|array',
            'installment_plan'    => 'nullable|array',
            'best_selling'        => 'sometimes|boolean',
            'today_deal'          => 'sometimes|boolean',
            'approved'            => 'sometimes|boolean',
            'status'              => 'required|in:enabled,disabled',
            'map_embed'           => 'nullable|string',
            'video_embed'         => 'nullable|string',
            'short_video_url'     => 'nullable|string',
            'extra_data'          => 'nullable|string',
            'main_image'          => 'nullable|image|max:2048',
            'gallery.*'           => 'nullable|image|max:2048',
        ]);
        
        DB::beginTransaction();

        try {
            // 2️⃣ Generate SEO via AI
            $seo = $this->aiService->generate($data['title'], $data['location'] ?? '');
            $data['keywords'] = $seo['seo_keywords'];

            // 3️⃣ Create Property
            $property = Property::create($data);

            // 4️⃣ Media uploads
            if ($request->hasFile('main_image')) {
                $property
                    ->addMediaFromRequest('main_image')
                    ->toMediaCollection('main_image');
            }
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $img) {
                    $property
                        ->addMedia($img)
                        ->toMediaCollection('gallery');
                }
            }

            DB::commit();
            return redirect()
                ->route('admin.properties.index')
                ->with('success', 'Property created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('PropertyController@store failed:', [
                'error'   => $e->getMessage(),
                'payload' => $data,
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Failed to create property.',
                    'errors'  => ['server' => $e->getMessage()],
                ], 500);
            }
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified property.
     *
     * @param  Property  $property
     * @return View
     */
    public function show(Property $property)
    {
        return view('admin.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified property.
     *
     * @param  Property  $property
     * @return View
     */
    public function edit(Property $property)
    {
        $users          = User::all();
        $societies      = Society::all();
        $subsectors     = SubSector::where('society_id', $property->society_id)->get();
        $featuresConfig = [
            'bedrooms'         => 'Bedrooms',
            'bathrooms'        => 'Bathrooms',
            'garage_capacity'  => 'Garage',
            'drawing_rooms'    => 'Drawing Rooms',
            'kitchens'         => 'Kitchens',
            'study_rooms'      => 'Study Rooms',
            'store_rooms'      => 'Store Rooms',
            'servant_quarters' => 'Servant Quarters',
            'sitting_rooms'    => 'Sitting Rooms',
        ];

        return view('admin.properties.edit', compact(
            'property', 'users', 'societies', 'subsectors', 'featuresConfig'
        ));
    }

    /**
     * Update the specified property.
     *
     * @param Request $request
     * @param Property $property
     * @return RedirectResponse
     * @throws ConnectionException
     */
    public function update(Request $request, Property $property)
    {
        $data = $request->validate([
            'user_id'             => 'required|exists:users,id',
            'society_id'          => 'required|exists:societies,id',
            'sub_sector_id'       => 'nullable|exists:sub_sectors,id',
            'title'               => 'required|string|max:255',
            'slug'                => 'required|string|max:255|unique:properties,slug,'.$property->id,
            'purpose'             => 'required|in:sale,rent',
            'property_type'       => 'required|string|max:50',
            'plot_size'           => 'nullable|string|max:100',
            'plot_dimensions'     => 'nullable|string|max:100',
            'price'               => 'nullable|numeric',
            'rent'                => 'nullable|numeric',
            'rent_type'           => 'nullable|in:monthly,yearly',
            'plot_no'             => 'nullable|string|max:50',
            'street'              => 'nullable|string|max:100',
            'location'            => 'nullable|string|max:255',
            'latitude'            => 'nullable|numeric',
            'longitude'           => 'nullable|numeric',
            'description'         => 'nullable|string',
            'keywords'            => 'nullable|string',
            'features'            => 'nullable|array',
            'features.*'          => 'nullable|integer',
            'nearby_facilities'   => 'nullable|array',
            'installment_plan'    => 'nullable|array',
            'best_selling'        => 'sometimes|boolean',
            'today_deal'          => 'sometimes|boolean',
            'approved'            => 'sometimes|boolean',
            'status'              => 'required|in:enabled,disabled',
            'map_embed'           => 'nullable|string',
            'video_embed'         => 'nullable|string',
            'short_video_url'     => 'nullable|string',
            'extra_data'          => 'nullable|string',
            'main_image'          => 'nullable|image|max:2048',
            'gallery.*'           => 'nullable|image|max:2048',
        ]);

        // Regenerate SEO keywords
        $seo = $this->aiService->generate($data['title'], $data['location'] ?? '');
        $data['keywords'] = $seo['seo_keywords'];

        $property->update($data);

        if ($request->hasFile('main_image')) {
            $property->clearMediaCollection('main_image');
            try {
                $property
                    ->addMediaFromRequest('main_image')
                    ->toMediaCollection('main_image');
            } catch (FileDoesNotExist|FileIsTooBig $e) {

            }
        }

        if ($request->hasFile('gallery')) {
            $property->clearMediaCollection('gallery');
            foreach ($request->file('gallery') as $img) {
                try {
                    $property
                        ->addMedia($img)
                        ->toMediaCollection('gallery');
                } catch (FileDoesNotExist|FileIsTooBig $e) {

                }
            }
        }

        return redirect()
            ->route('admin.properties.index')
            ->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified property.
     *
     * @param  Property  $property
     * @return RedirectResponse
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()
            ->route('admin.properties.index')
            ->with('success', 'Property deleted successfully.');
    }
    /**
     * Get all subsectors for a society.
     */
    public function getSubsectors($societyId): JsonResponse
    {
        $subs = SubSector::where('society_id',$societyId)
            ->select('id','name')->orderBy('name')->get();
        return response()->json($subs);
    }

    /**
     * Get all blocks for a subsector (or, if blocks are not a table, send back a unique list of block field).
     */
    public function getBlocks($subsectorId): JsonResponse
    {
        $blocks = SubSector::where('id',$subsectorId)
            ->pluck('block')->unique()->filter()->values()
            ->map(fn($name,$i)=>['id'=>$i+1,'name'=>$name]);
        return response()->json($blocks);
    }
}
