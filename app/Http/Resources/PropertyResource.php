<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * parent::toArray() will include:
     *   • all fillable attributes on Property
     *   • automatically cast fields (features, etc.)
     *
     * We then append:
     *   • property_image (URL for the largest responsive breakpoint)
     *   • property_image_responsive (full array of URLs, to build srcset)
     *   • gallery_urls (array of full URLs for each “gallery” item)
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $f          = $this->features ?? [];
        $responsive = [];

        foreach ($this->getMedia('property_image') as $mediaItem) {
            if (isset($mediaItem->responsive_images['media_library_original']['urls'])) {
                foreach ($mediaItem->responsive_images['media_library_original']['urls'] as $filename) {
                    // this assumes Spatie wrote the responsive files to:
                    // storage/app/public/{mediaId}/responsive-images/{filename}
                    $responsive[] = asset("storage/{$mediaItem->id}/responsive-images/{$filename}");
                }
            } else {
                // fallback to the original
                $responsive[] = $mediaItem->getFullUrl();
            }
        }
        return [
            'id'                        => $this->id,
            'title'                     => $this->title,
            'name'                      => $this->name,
            'slug'                      => $this->slug,
            'price'                     => $this->price,
            'purpose'                   => $this->purpose,
            'location'                  => $this->location,
            'views'                     => $this->views,
            'plot_size'                 => $this->plot_size,
            'beds'                      => (int) data_get($f, 'bed_rooms', data_get($f, 'beds', 0)),
            'baths'                     => (int) data_get($f, 'bath_rooms', data_get($f, 'baths', 0)),
            'created_at'                => $this->created_at->toDateTimeString(),

            // give the browser a real URL
            'property_image_url'        => count($responsive)
                ? $responsive[0]
                : asset('assets/admin/images/property/placeholder.jpg'),

            // full list of full URLs for srcset
            'property_image_responsive' => $responsive,

            // ← here’s the null-safe guard
            'society_name'              => $this->society?->name,
            'society_slug'              => $this->society?->slug,
        ];
    }
}
