<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FrontPropertyController extends Controller
{
    /**
     * Return a JSON list of “featured” properties (best selling, approved, active).
     * Wrapped in PropertyResource so each property includes:
     *   • all fillable attributes
     *   • property_image_url (largest responsive breakpoint)
     *   • property_image_responsive (all breakpoints → srcset)
     *   • gallery_urls
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
     * Perform a filtered property search.
     *
     * Accepts query parameters:
     *   • purpose     (sale | rent | instalments)
     *   • category    (homes, plots, apartments, shop, etc.)
     *   • keyword     (search in title or description, case-insensitive)
     *   • min_price   (integer)
     *   • max_price   (integer)
     *
     * Returns up to 12 matching properties wrapped in PropertyResource.
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

        $properties = $query
            ->with(['media', 'society'])
            ->orderByDesc('created_at')
            ->limit(12)
            ->get();

        return PropertyResource::collection($properties)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Show a single property’s detail.
     *
     * • If JSON requested (wantsJson()), return a structured payload:
     *   – id, title, address, size, beds, baths, description paragraphs
     *   – images[] (gallery or single fallback)
     *   – map_embed, price, status, days_on_market, price_per_sqf, monthly_payment
     *
     * • Otherwise, render the Blade view: front.property-detail
     *   and pass the Eloquent $property model.
     */
    public function show(Request $request, string $slug)
    {
        $property = Property::where('slug', $slug)
            ->where('approved', true)
            ->where('status', 'active')
            ->firstOrFail();

        if ($request->wantsJson()) {
            $galleryItems = $property->getMedia('gallery');

            if ($galleryItems->isEmpty()) {
                $singleUrl = $property->getFirstMediaUrl('property_image');
                $images = $singleUrl
                    ? [['url' => $singleUrl]]
                    : [];
            } else {
                $images = $galleryItems
                    ->map(fn(Media $m) => ['url' => $m->getUrl()])
                    ->all();
            }

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
                    'beds'                   => $property->features['beds'] ?? null,
                    'baths'                  => $property->features['baths'] ?? null,
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
