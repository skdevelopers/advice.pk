<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class FrontPropertyController extends Controller
{
    /**
     * Return featured properties (for homepage carousel/sections).
     *
     * @return JsonResponse
     */
    public function featured(): JsonResponse
    {
        $properties = Property::query()
            ->where('approved', true)
            ->where('status', 'active')
            ->where('best_selling', true)
            ->with(['media', 'society'])
            ->orderByDesc('created_at')
            ->limit(6)
            ->get()
            ->map(fn($property) => $this->transform($property));

        return response()->json(['data' => $properties]);
    }

    /**
     * Get static property search options (categories, price ranges, etc).
     *
     * @return JsonResponse
     */
    public function searchOptions(): JsonResponse
    {
        return response()->json([
            'categories' => [
                ['label' => 'All Categories', 'value' => ''],
                ['label' => 'Houses', 'value' => 'Houses'],
                ['label' => 'Apartment', 'value' => 'Apartment'],
                ['label' => 'Offices', 'value' => 'Offices'],
                ['label' => 'Townhome', 'value' => 'Townhome'],
            ],
            'min_prices' => [
                ['label' => 'Min Price', 'value' => ''],
                ['label' => '500', 'value' => '500'],
                ['label' => '1000', 'value' => '1000'],
                ['label' => '2000', 'value' => '2000'],
                ['label' => '3000', 'value' => '3000'],
                ['label' => '4000', 'value' => '4000'],
                ['label' => '5000', 'value' => '5000'],
                ['label' => '6000', 'value' => '6000'],
            ],
            'max_prices' => [
                ['label' => 'Max Price', 'value' => ''],
                ['label' => '500', 'value' => '500'],
                ['label' => '1000', 'value' => '1000'],
                ['label' => '2000', 'value' => '2000'],
                ['label' => '3000', 'value' => '3000'],
                ['label' => '4000', 'value' => '4000'],
                ['label' => '5000', 'value' => '5000'],
                ['label' => '6000', 'value' => '6000'],
            ],
        ]);
    }


    /**
     * Search properties by filter.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query = Property::query()
            ->where('approved', true)
            ->where('status', 'active');

        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }
        if ($request->filled('category')) {
            $query->where('property_type', $request->category);
        }
        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'ilike', "%{$request->keyword}%")
                    ->orWhere('description', 'ilike', "%{$request->keyword}%");
            });
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int) $request->max_price);
        }

        $properties = $query->with(['media', 'society'])
            ->orderByDesc('created_at')
            ->limit(12)
            ->get()
            ->map(fn($property) => $this->transform($property));

        return response()->json(['data' => $properties]);
    }

    /**
     * Show property details by slug.
     *
     * If the request wants JSON (Axios call to /api/properties/{slug}), this returns JSON.
     * Otherwise, return the Blade view.
     *
     * @param  Request  $request
     * @param  string   $slug
     * @return Application|Factory|View|JsonResponse|object
     */
    public function show(Request $request, string $slug)
    {
        // 1) Load the property or 404. (No more with('images'), since Spatie uses MediaLibrary.)
        $property = Property::where('slug', $slug)
            ->where('approved', true)
            ->where('status', 'active')
            ->firstOrFail();

        // 2) If JSON is explicitly requested, build an array of URLs from the media collection:
        if ($request->wantsJson()) {
            // Use the 'gallery' collection (or 'property_image' if you only have a single file).
            $mediaItems = $property->getMedia('gallery');
            // If you only ever store one image in 'property_image', comment out the above line and uncomment below:
            // $mediaItems = $property->getMedia('property_image');

            $images = collect($mediaItems)->map(function ($media) {
                return [
                    // getFullUrl() returns the absolute URL; getUrl() returns relative if you prefer.
                    'url' => $media->getUrl(),
                ];
            })->all();

            // Split description into paragraphs (same as before).
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
                    'address'                => $property->location,      // adjust if you use $property->address vs $property->location
                    'size'                   => $property->plot_size,    // or $property->size if that’s the column
                    'beds'                   => $property->features['beds'] ?? null,   // adjust if you store beds/baths inside features array
                    'baths'                  => $property->features['baths'] ?? null,  // (Or from dedicated columns)
                    'description_paragraphs' => $descriptionParagraphs,
                    'images'                 => $images,
                    'map_embed'              => $property->map_embed,    // your column is `map_embed`
                    'price'                  => (float) $property->price,
                    'status'                 => $property->status,
                    'days_on_market'         => $property->views,         // or however you calculate days_on_market
                    'price_per_sqf'          => (float) $property->price / (float) ($property->plot_size ?: 1),
                    'monthly_payment'        => (float) ($property->price / 12),
                ],
            ]);
        }

        // 3) Otherwise (standard web request), return the Blade view and pass the Eloquent model.
        return view('front.property-detail', compact('property'));
    }
    /**
     * Transform property for API output.
     *
     * @param Property $property
     * @param bool $detailed
     * @return array
     */
    private function transform(Property $property, bool $detailed = false): array
    {
        return [
            'id' => $property->id,
            'title' => $property->title,
            'slug' => $property->slug,
            'purpose' => $property->purpose,
            'property_type' => $property->property_type,
            'area' => $property->plot_size,
            'beds' => $property->features['beds'] ?? null,
            'baths' => $property->features['baths'] ?? null,
            'price' => $property->price,
            'location' => $property->location,
            'property_image' => $property->getFirstMediaUrl('property_image') ?: asset('assets/front/images/about.jpg'),
            'gallery' => $property->getMedia('gallery')->map->getUrl(),
            'society' => $property->society?->name,
            'created_at' => $property->created_at->toDateString(),
            'rating' => 5, // Placeholder or real calculation
            'description' => $detailed ? Str::limit($property->description, 2000) : null,
            // add any more detailed fields as needed
        ];
    }
}
