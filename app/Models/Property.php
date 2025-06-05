<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class Property
 *
 * @property int $id
 * @property int $user_id
 * @property int $society_id
 * @property int|null $sub_sector_id
 * @property string $purpose
 * @property string $property_type
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string|null $keywords
 * @property string|null $plot_no
 * @property string|null $street
 * @property string|null $location
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $plot_size
 * @property string|null $plot_dimensions
 * @property int|null $price
 * @property int|null $rent
 * @property string $rent_type
 * @property array<array-key, mixed>|null $features
 * @property array<array-key, mixed>|null $nearby_facilities
 * @property array<array-key, mixed>|null $installment_plan
 * @property bool $best_selling
 * @property bool $today_deal
 * @property bool $approved
 * @property string $status
 * @property string|null $map_embed
 * @property string|null $video_embed
 * @property string|null $short_video_url
 * @property string|null $extra_data
 * @property string|null $created_by
 * @property int $views
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Society $society
 * @property-read SubSector|null $subsector
 * @property-read User $user
 * @method static Builder<static>|Property newModelQuery()
 * @method static Builder<static>|Property newQuery()
 * @method static Builder<static>|Property onlyTrashed()
 * @method static Builder<static>|Property query()
 * @method static Builder<static>|Property whereApproved($value)
 * @method static Builder<static>|Property whereBestSelling($value)
 * @method static Builder<static>|Property whereCreatedAt($value)
 * @method static Builder<static>|Property whereCreatedBy($value)
 * @method static Builder<static>|Property whereDeletedAt($value)
 * @method static Builder<static>|Property whereDescription($value)
 * @method static Builder<static>|Property whereExtraData($value)
 * @method static Builder<static>|Property whereFeatures($value)
 * @method static Builder<static>|Property whereId($value)
 * @method static Builder<static>|Property whereInstallmentPlan($value)
 * @method static Builder<static>|Property whereKeywords($value)
 * @method static Builder<static>|Property whereLatitude($value)
 * @method static Builder<static>|Property whereLocation($value)
 * @method static Builder<static>|Property whereLongitude($value)
 * @method static Builder<static>|Property whereMapEmbed($value)
 * @method static Builder<static>|Property whereNearbyFacilities($value)
 * @method static Builder<static>|Property wherePlotDimensions($value)
 * @method static Builder<static>|Property wherePlotNo($value)
 * @method static Builder<static>|Property wherePlotSize($value)
 * @method static Builder<static>|Property wherePrice($value)
 * @method static Builder<static>|Property wherePropertyType($value)
 * @method static Builder<static>|Property wherePurpose($value)
 * @method static Builder<static>|Property whereRent($value)
 * @method static Builder<static>|Property whereRentType($value)
 * @method static Builder<static>|Property whereShortVideoUrl($value)
 * @method static Builder<static>|Property whereSlug($value)
 * @method static Builder<static>|Property whereSocietyId($value)
 * @method static Builder<static>|Property whereStatus($value)
 * @method static Builder<static>|Property whereStreet($value)
 * @method static Builder<static>|Property whereSubSectorId($value)
 * @method static Builder<static>|Property whereTitle($value)
 * @method static Builder<static>|Property whereTodayDeal($value)
 * @method static Builder<static>|Property whereUpdatedAt($value)
 * @method static Builder<static>|Property whereUserId($value)
 * @method static Builder<static>|Property whereVideoEmbed($value)
 * @method static Builder<static>|Property whereViews($value)
 * @method static Builder<static>|Property withTrashed()
 * @method static Builder<static>|Property withoutTrashed()
 * @mixin Eloquent
 */
class Property extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;


    protected $fillable = [
        'user_id',
        'society_id',
        'sub_sector_id',
        'title',
        'slug',
        'description',
        'keywords',
        'purpose',
        'property_type',
        'plot_size',
        'plot_dimensions',
        'price',
        'rent',
        'rent_type',
        'plot_no',
        'street',
        'location',
        'latitude',
        'longitude',
        'features',
        'nearby_facilities',
        'installment_plan',
        'best_selling',
        'today_deal',
        'approved',
        'status',
        'map_embed',
        'video_embed',
        'short_video_url',
        'extra_data',
        'created_by',
        'views',
    ];

    protected $casts = [
        'features' => 'array',
        'nearby_facilities' => 'array',
        'installment_plan' => 'array',
        'best_selling' => 'boolean',
        'today_deal' => 'boolean',
        'approved' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    // 1) tell Eloquent to include this in toArray()/toJson()
    protected $appends = ['property_image_url'];

    /**
     * Return the first “property_image” (thumb conversion) or a placeholder.
     */
    public function getPropertyImageUrlAttribute(): string
    {
        // Attempt to get the "thumb" conversion URL (registered below).
        $url = $this->getFirstMediaUrl('property_image', 'thumb');

        // If Spatie did not generate a "thumb", fall back to the original file:
        if (! $url) {
            $url = $this->getFirstMediaUrl('property_image');
        }

        // If still empty, use a generic placeholder
        return $url ?: asset('assets/admin/images/hero.jpg');
    }

    /**
     * Register media collections and conversions.
     */
    public function registerMediaCollections(?Media $media = null): void
    {
        // Single file “property_image” with responsive images and a "thumb" conversion
        $this
            ->addMediaCollection('property_image')
            ->singleFile()
            ->withResponsiveImages();

        // “gallery” can have multiple images, each with responsive conversions
        $this
            ->addMediaCollection('gallery')
            ->withResponsiveImages();

        // (If you have documents, you can register them here as well)
        $this
            ->addMediaCollection('documents')
            ->withResponsiveImages();
    }

    /**
     * If you want a custom “thumb” conversion (for exactly 12rem×12rem),
     * uncomment this and tailor the width/height to roughly match 12rem (192px).
     *
     * NOTE: You can omit this method entirely if you rely on Spatie’s default responsive breakpoints.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(480)   // 480 px wide (approx “12rem” at 40px root font size)
            ->height(360)  // adjust to your desired aspect ratio
            ->sharpen(10)
            ->nonQueued()  // generate immediately; or queue if you prefer
            ->withResponsiveImages();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function society(): BelongsTo
    {
        return $this->belongsTo(Society::class);
    }

    public function subsector(): BelongsTo
    {
        return $this->belongsTo(SubSector::class);
    }

}
