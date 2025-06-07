<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FrontPropertyController extends Controller
{
    /**
     * Return a JSON list of “featured” properties (best selling, approved, active).
     * We select only the columns needed by the front-end template, eager‐load a filtered
     * media relationship, and cache the result for 60 seconds.
     */
    public function featured(): JsonResponse
    {
        // Cache the featured properties for 60 seconds to reduce DB load
        $properties = cache()->remember('featured_properties', 60, function() {
            return Property::query()
                ->where('approved', true)
                ->where('status', 'active')
                ->where('best_selling', true)
                // Only select the columns you actually use in the template
                ->select([
                    'id','title','slug','price','purpose',
                    'location','views','plot_size','features','created_at',
                ])
                ->with([
                    'media'   => fn($q) => $q
                        ->where('collection_name','property_image')
                        ->orderBy('order_column'),
                    'society:id,name,slug',
                ])
                ->orderByDesc('created_at')
                ->limit(6)
                ->get();
        });

        // The PropertyResource will convert each model into exactly the JSON fields the front-end needs,
        // including building property_image_url and property_image_responsive from the loaded media.
        return PropertyResource::collection($properties)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Perform a filtered property search.
     *
     * We only select the columns needed for the search results, eager‐load media and society,
     * then return at most 12 items. We also avoid large JSON payloads by selecting only
     * the fields you actually render in your front-end.
     */
    public function search(Request $request): JsonResponse
    {
        $query = Property::query()
            ->where('approved', true)
            ->where('status', 'active');

        if ($request->filled('purpose')) {
            $query->where('purpose', $request->input('purpose'));
        }

        if ($request->filled('category')) {
            $query->where('property_type', $request->input('category'));
        }

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'ILIKE', "%{$keyword}%")
                    ->orWhere('description', 'ILIKE', "%{$keyword}%");
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int) $request->input('max_price'));
        }

        // Select only the columns you will show in the search results
        $properties = $query
            ->select([
                'id','title','slug','price','purpose',
                'location','views','plot_size','features','created_at',
            ])
            ->with([
                'media'   => fn($q) => $q
                    ->where('collection_name','property_image')
                    ->orderBy('order_column', 'asc'),
                'society:id,name,slug',
            ])
            ->orderByDesc('created_at')
            ->limit(12)
            ->get();

        return PropertyResource::collection($properties)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Return static search options for the front-end “search” form:
     *   • categories (property types)
     *   • minimum prices
     *   • maximum prices
     */
    public function searchOptions(): JsonResponse
    {
        return response()->json([
            'categories' => [
                ['label' => 'All Categories', 'value' => ''],
                ['label' => 'Homes',         'value' => 'homes'],
                ['label' => 'Plots',         'value' => 'plots'],
                ['label' => 'Apartments',    'value' => 'apartments'],
                ['label' => 'Shop',          'value' => 'shop'],
                ['label' => 'Farm Houses',   'value' => 'farm_houses'],
                ['label' => 'Agri Land',     'value' => 'agriland'],
            ],
            'min_prices' => [
                ['label' => 'Min Price',   'value' => ''],
                ['label' => '1,000,000',   'value' => '1000000'],
                ['label' => '5,000,000',   'value' => '5000000'],
                ['label' => '10,000,000',  'value' => '10000000'],
                ['label' => '15,000,000',  'value' => '15000000'],
                ['label' => '20,000,000',  'value' => '20000000'],
            ],
            'max_prices' => [
                ['label' => 'Max Price',   'value' => ''],
                ['label' => '5,000,000',   'value' => '5000000'],
                ['label' => '10,000,000',  'value' => '10000000'],
                ['label' => '15,000,000',  'value' => '15000000'],
                ['label' => '20,000,000',  'value' => '20000000'],
                ['label' => '25,000,000',  'value' => '25000000'],
            ],
        ]);
    }

    /**
     * Show a single property’s detail.
     */
    public function show(Request $request, string $slug)
    {
        $property = Property::where('slug', $slug)
            ->where('approved', true)
            ->where('status', 'active')
            ->with(['media', 'society'])
            ->firstOrFail();

        if ($request->wantsJson()) {
            // Build gallery images (fallback if none exist)
            $galleryItems = $property->getMedia('gallery');
            if ($galleryItems->isEmpty()) {
                $singleUrl = $property->getFirstMediaUrl('property_image');
                $images = $singleUrl ? [['url' => $singleUrl]] : [];
            } else {
                $images = $galleryItems->map(fn(Media $m) => ['url' => $m->getUrl()])->all();
            }

            // Split description into paragraphs
            $descriptionParagraphs = [];
            if (!empty($property->description)) {
                $descriptionParagraphs = array_filter(
                    array_map('trim', explode("\n\n", $property->description))
                );
            }

            return response()->json([
                'data' => [
                    'id'                     => $property->id,
                    'title'                  => $property->title,
                    'address'                => $property->location,
                    'size'                   => $property->plot_size,
                    'beds_rooms'                   => $property->beds_rooms ?? 0,
                    'baths_rooms'                  => $property->baths_rooms ?? 0,
                    'description_paragraphs' => $descriptionParagraphs,
                    'images'                 => $images,
                    'map_embed'              => $property->map_embed,
                    'price'                  => (float) $property->price,
                    'status'                 => $property->status,
                    'days_on_market'         => $property->views,
                    'price_per_sqf'          => $property->plot_size
                        ? (float) $property->price / (float) str_replace(' ', '', $property->plot_size)
                        : null,
                    'monthly_payment'        => $property->price / 12.0,
                ]
            ], 200);
        }

        return view('front.property-detail', compact('property'));
    }
}
