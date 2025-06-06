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
        $data = parent::toArray($request);

        $media = $this->getFirstMedia('property_image');

        if ($media) {
            $data['property_image'] = $media->getUrl();
            $data['property_image_responsive'] = $media->getResponsiveImageUrls();
        } else {
            $data['property_image'] = null;
            $data['property_image_responsive'] = [];
        }

        $data['gallery_urls'] = $this->getMedia('gallery')
            ->map->getUrl()
            ->all();

        return $data;
    }
}
