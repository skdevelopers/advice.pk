<?php

namespace App\Http\Controllers;

use App\Models\Property;
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
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        $property = Property::with(['media', 'society', 'user'])
            ->where('slug', $slug)
            ->where('approved', true)
            ->where('status', 'active')
            ->firstOrFail();

        return response()->json(['data' => $this->transform($property, true)]);
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
