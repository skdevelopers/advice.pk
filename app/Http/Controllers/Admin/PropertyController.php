<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
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
     * If the request expects JSON (e.g. via axios), returns
     * a JSON payload with:
     *  - data: array of properties (with relations: user, society, subsector)
     *  - links: pagination links
     *  - meta: pagination metadata
     *
     * Otherwise, renders the HTML view which will then
     * bootstrap the axios fetch on the client side.
     *
     * @param  Request  $request
     * @return View|JsonResponse
     */
    public function index(Request $request)
    {
        $properties = Property::with(['user','society','subsector'])
            ->latest()
            ->paginate(10);

        if ($request->wantsJson()) {
            // wrap the *paginated* collection
            return PropertyResource::collection($properties)
                ->response()
                ->setStatusCode(200);
        }

        return view('admin.properties.index');
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
     * @param StorePropertyRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws Throwable
     */
    public function store(StorePropertyRequest $request)
    {
        // 1️⃣ Validate all fields, including uploads and dynamic arrays
        $data = $request->validated();

        DB::beginTransaction();

        try {
            // 2️⃣ Generate SEO via AI
            $seo = $this->aiService->generate($data['title'], $data['location'] ?? '');
            $data['keywords'] = $seo['seo_keywords'];

            // 3️⃣ Create Property
            $property = Property::create($data);

            // 4️⃣ Media uploads
            if ($request->hasFile('property_image')) {
                $property
                    ->addMediaFromRequest('property_image')
                    ->toMediaCollection('property_image');
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
     * @param UpdatePropertyRequest $request
     * @param Property $property
     * @return RedirectResponse
     * @throws ConnectionException
     */
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $data = $request->validated();

        // Regenerate SEO keywords
        $seo = $this->aiService->generate($data['title'], $data['location'] ?? '');
        $data['keywords'] = $seo['seo_keywords'];

        $property->update($data);

        if ($request->hasFile('property_image')) {
            $property->clearMediaCollection('property_image');
            try {
                $property
                    ->addMediaFromRequest('property_image')
                    ->toMediaCollection('property_image');
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
