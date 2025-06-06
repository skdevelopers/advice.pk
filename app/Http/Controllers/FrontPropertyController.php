<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class FrontPropertyController
 *
 * Handles all front-end property endpoints (JSON or Blade) for:
 *  • featured properties
 *  • search options
 *  • property search
 *  • property detail
 */
class FrontPropertyController extends Controller
{
    /**
     * Return a JSON list of “featured” properties (best selling, approved, active).
     *
     * Each Property is wrapped in PropertyResource, which includes:
     *  • all fillable attributes
     *  • property_image URL
     *  • property_image_responsive URLs (srcset)
     *  • gallery_urls
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
            ->get();

        return PropertyResource::collection($properties)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Return static search options for the front-end “search” form:
     *  • categories (property types)
     *  • minimum prices
     *  • maximum prices
     *
     * These will be used by the client to populate dropdowns.
     *
     * @return JsonResponse
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
                ['label' => 'Min Price', 'value' => ''],
                ['label' => '1,000,000',  'value' => '1000000'],
                ['label' => '5,000,000',  'value' => '5000000'],
                ['label' => '10,000,000', 'value' => '10000000'],
                ['label' => '15,000,000', 'value' => '15000000'],
                ['label' => '20,000,000', 'value' => '20000000'],
            ],
            'max_prices' => [
                ['label' => 'Max Price', 'value' => ''],
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
     *  • purpose     (sale | rent | instalments)
     *  • category    (homes, plots, apartments, shop, etc.)
     *  • keyword     (search in title or description, case-insensitive)
     *  • min_price   (integer)
     *  • max_price   (integer)
     *
     * Returns up to 12 matching properties, wrapped in PropertyResource.
     *
     * @param  Request  $request
     * @return JsonResponse
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
     * • If the client wants JSON (wantsJson()), return a JSON object with:
     *   – id, title, address, size, beds, baths, paragraphs of description
     *   – images[]: either from ‘gallery’ or fallback to single ‘property_image’
     *   – map_embed, price, status, days_on_market, price_per_sqf, monthly_payment
     *
     * • Otherwise, render the Blade template: resources/views/front/property-detail.blade.php
     *   and pass the Eloquent $property model.
     *
     * @param  Request  $request
     * @param  string   $slug
     * @return Application|Factory|JsonResponse|View
     */
    public function show(Request $request, string $slug)
    {
        // 1. Load or fail
        $property = Property::where('slug', $slug)
            ->where('approved', true)
            ->where('status', 'active')
            ->firstOrFail();

        // 2. If JSON requested, build a structured payload
        if ($request->wantsJson()) {
            // Gather “gallery” media if exists
            $galleryItems = $property->getMedia('gallery');

            if ($galleryItems->isEmpty()) {
                // Fallback to single property_image
                $singleUrl = $property->getFirstMediaUrl('property_image');
                $images = $singleUrl
                    ? [['url' => $singleUrl]]
                    : [];
            } else {
                // Map each Media to ['url' => …]
                $images = $galleryItems
                    ->map(fn(Media $m) => ['url' => $m->getUrl()])
                    ->all();
            }

            // Break description into paragraphs
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

        // 3. Otherwise render the Blade view
        return view('front.property-detail', compact('property'));
    }
}
