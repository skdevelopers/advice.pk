<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        // parent::toArray() will dump *all* fillable and castable attributes
        $data = parent::toArray($request);

        // append your media URLs
        $media = $this->getFirstMedia('property_image');
        $data['property_image']            = $media ? $media->getUrl() : null;
        $data['property_image_responsive'] = $media
            ? $media->getResponsiveImageUrls()
            : [];

        // if you want gallery too:
        $data['gallery_urls'] = $this->getMedia('gallery')
            ->map->getUrl();

        return $data;
    }
}
