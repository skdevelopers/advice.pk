<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PropertyResource
 *
 * Shapes property JSON for the front-end cards and lists.
 */
class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        // Society relation might be missing in some queries; guard nulls.
        $society = $this->whenLoaded('society');

        return [
            'id'                       => (int) $this->id,
            'title'                    => (string) ($this->title ?? 'Advice Associates'),
            'slug'                     => (string) ($this->slug ?? '#'),
            'price'                    => (int) ($this->price ?? 0),
            'purpose'                  => (string) ($this->purpose ?? ''), // 'sale' | 'rent'
            'today_deal'               => (bool) ($this->today_deal ?? false),

            // location used under the price line
            'location'                 => (string) ($this->location ?? ''),

            // overlays / stats
            'views'                    => (int) ($this->views ?? 0),
            'gallery_count'            => (int) ($this->getMedia('gallery')->count()),

            // icons row
            'plot_size'                => (string) ($this->plot_size ?? ''),
            'beds'                     => (int) ($this->beds ?? 0),
            'baths'                    => (int) ($this->baths ?? 0),

            // media (absolute)
            'property_image_url'       => (string) $this->property_image_url,
            'property_image_responsive'=> (array)  $this->property_image_responsive,

            // society meta (optional)
            'society_name'             => $society?->name,
            'society_slug'             => $society?->slug,

            // useful for UI sorting/labels
            'created_at'               => optional($this->created_at)->toDateTimeString(),
        ];
    }
}
