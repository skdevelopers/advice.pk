<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, string $slug)
    {
        // 1) Load the property or fail with a 404
        $property = Property::where('slug', $slug)
            ->where('approved', true)
            ->where('status', 'active')
            ->firstOrFail();

        // 2) JSON path: build an "images" array from either 'gallery' or fallback to 'property_image'
        if ($request->wantsJson()) {
            // Try to pull _all_ media from the 'gallery' collection:
            $galleryItems = $property->getMedia('gallery');

            // If gallery is empty, look for a single URL in 'property_image'
            if ($galleryItems->isEmpty()) {
                // getFirstMediaUrl() returns a string URL or empty string
                $singleUrl = $property->getFirstMediaUrl('property_image');

                if ($singleUrl) {
                    // Instead of trying to wrap a fake Media object, just build a plain array:
                    $images = [
                        ['url' => $singleUrl]
                    ];
                } else {
                    // Neither gallery nor property_image had anything
                    $images = [];
                }
            } else {
                // Map real Media objects to ['url' => …] arrays
                $images = $galleryItems
                    ->map(fn(Media $m) => [
                        'url' => $m->getUrl()
                    ])
                    ->all();
            }

            // Split description into paragraphs (same as before)
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
                    'address'                => $property->location,   // or $property->address if that’s your column
                    'size'                   => $property->plot_size,  // adjust if your column is different
                    'beds'                   => $property->features['beds'] ?? null,
                    'baths'                  => $property->features['baths'] ?? null,
                    'description_paragraphs' => $descriptionParagraphs,
                    'images'                 => $images,
                    'map_embed'              => $property->map_embed,  // your column name, not map_embed_url
                    'price'                  => (float) $property->price,
                    'status'                 => $property->status,
                    'days_on_market'         => $property->views,       // or whichever logic you use
                    'price_per_sqf'          => (float) $property->price / (float) ($property->plot_size ?: 1),
                    'monthly_payment'        => (float) ($property->price / 12),
                ]
            ]);
        }

        // 3) Otherwise (web request), render your Blade and pass the $property model
        return view('front.property-detail', compact('property'));
    }


    /**
     * Transform property for API output.
     *
     * @param Property $property
     * @return array
     */
    private function transform(Property $property): array
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
            'primary_image_url'  => $property->property_image_url,
            // Full gallery (used elsewhere, if needed):
            'gallery'            => $property->getMedia('gallery')
                ->map(fn($m) => $m->getFullUrl())
                ->all(),
            'views'              => $property->views,
            'whatsapp_number'    => $property->whatsapp_number ?? '',
            'phone'              => $property->phone ?? '',
            'society' => $property->society?->name,
            'created_at' => $property->created_at->toDateString(),
            'rating' => 5, // Placeholder or real calculation
            'description' => false ? Str::limit($property->description, 2000) : null,
            // add any more detailed fields as needed
        ];
    }
}
