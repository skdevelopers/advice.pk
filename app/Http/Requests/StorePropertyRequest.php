<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        // adjust if you have permissions logic
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'           => 'required|exists:users,id',
            'society_id'        => 'required|exists:societies,id',
            'sub_sector_id'     => 'nullable|exists:sub_sectors,id',
            'title'             => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:properties,slug',
            'purpose'           => 'required|in:sale,rent,instalments',
            'property_type'     => 'required|string|in:homes,plots,apartments,shop,farm_houses,farm_house_plots,agriland',
            'plot_size'         => 'nullable|string|max:100',
            'plot_dimensions'   => 'nullable|string|max:100',
            'price'             => 'nullable|numeric',
            'rent'              => 'nullable|numeric',
            'rent_type'         => 'nullable|in:monthly,yearly',
            'plot_no'           => 'nullable|string|max:50',
            'street'            => 'nullable|string|max:100',
            'location'          => 'nullable|string|max:255',
            'latitude'          => 'nullable|numeric',
            'longitude'         => 'nullable|numeric',
            'description'       => 'nullable|string',
            'keywords'          => 'nullable|string',
            'features'          => 'nullable|array',
            'features.*'        => 'nullable|integer',
            'nearby_facilities' => 'nullable|array',
            'installment_plan'  => 'nullable|array',
            'best_selling'      => 'sometimes|boolean',
            'today_deal'        => 'sometimes|boolean',
            'approved'          => 'sometimes|boolean',
            'status'            => 'required|in:enabled,disabled',
            'map_embed'         => 'nullable|string',
            'video_embed'       => 'nullable|string',
            'short_video_url'   => 'nullable|string',
            'extra_data'        => 'nullable|string',
            'main_image'        => 'nullable|image|max:2048',
            'gallery.*'         => 'nullable|image|max:2048',
        ];
    }
}
