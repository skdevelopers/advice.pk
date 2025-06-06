<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * Class Property
 *
 * Represents a real estate listing. Uses Spatie’s Media Library for responsive images.
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property int                             $society_id
 * @property int|null                        $sub_sector_id
 * @property string                          $purpose
 * @property string                          $property_type
 * @property string                          $title
 * @property string                          $slug
 * @property string|null                     $description
 * @property string|null                     $keywords
 * @property string|null                     $plot_no
 * @property string|null                     $street
 * @property string|null                     $location
 * @property float|null                      $latitude
 * @property float|null                      $longitude
 * @property string|null                     $plot_size
 * @property string|null                     $plot_dimensions
 * @property int|null                        $price
 * @property int|null                        $rent
 * @property string                          $rent_type
 * @property array<array-key, mixed>|null    $features
 * @property array<array-key, mixed>|null    $nearby_facilities
 * @property array<array-key, mixed>|null    $installment_plan
 * @property bool                            $best_selling
 * @property bool                            $today_deal
 * @property bool                            $approved
 * @property string                          $status
 * @property string|null                     $map_embed
 * @property string|null                     $video_embed
 * @property string|null                     $short_video_url
 * @property string|null                     $extra_data
 * @property string|null                     $created_by
 * @property int                             $views
 * @property Carbon|null                     $created_at
 * @property Carbon|null                     $updated_at
 * @property Carbon|null                     $deleted_at
 *
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null                   $media_count
 * @property-read Society                     $society
 * @property-read SubSector|null              $subsector
 * @property-read User                        $user
 *
 * @method static Builder<static>|Property    newModelQuery()
 * @method static Builder<static>|Property    newQuery()
 * @method static Builder<static>|Property    onlyTrashed()
 * @method static Builder<static>|Property    query()
 * @method static Builder<static>|Property    whereApproved($value)
 * @method static Builder<static>|Property    whereBestSelling($value)
 * @method static Builder<static>|Property    whereCreatedAt($value)
 * @method static Builder<static>|Property    whereCreatedBy($value)
 * @method static Builder<static>|Property    whereDeletedAt($value)
 * @method static Builder<static>|Property    whereDescription($value)
 * @method static Builder<static>|Property    whereExtraData($value)
 * @method static Builder<static>|Property    whereFeatures($value)
 * @method static Builder<static>|Property    whereId($value)
 * @method static Builder<static>|Property    whereInstallmentPlan($value)
 * @method static Builder<static>|Property    whereKeywords($value)
 * @method static Builder<static>|Property    whereLatitude($value)
 * @method static Builder<static>|Property    whereLocation($value)
 * @method static Builder<static>|Property    whereLongitude($value)
 * @method static Builder<static>|Property    whereMapEmbed($value)
 * @method static Builder<static>|Property    whereNearbyFacilities($value)
 * @method static Builder<static>|Property    wherePlotDimensions($value)
 * @method static Builder<static>|Property    wherePlotNo($value)
 * @method static Builder<static>|Property    wherePlotSize($value)
 * @method static Builder<static>|Property    wherePrice($value)
 * @method static Builder<static>|Property    wherePropertyType($value)
 * @method static Builder<static>|Property    wherePurpose($value)
 * @method static Builder<static>|Property    whereRent($value)
 * @method static Builder<static>|Property    whereRentType($value)
 * @method static Builder<static>|Property    whereShortVideoUrl($value)
 * @method static Builder<static>|Property    whereSlug($value)
 * @method static Builder<static>|Property    whereSocietyId($value)
 * @method static Builder<static>|Property    whereStatus($value)
 * @method static Builder<static>|Property    whereStreet($value)
 * @method static Builder<static>|Property    whereSubSectorId($value)
 * @method static Builder<static>|Property    whereTitle($value)
 * @method static Builder<static>|Property    whereTodayDeal($value)
 * @method static Builder<static>|Property    whereUpdatedAt($value)
 * @method static Builder<static>|Property    whereUserId($value)
 * @method static Builder<static>|Property    whereVideoEmbed($value)
 * @method static Builder<static>|Property    whereViews($value)
 * @method static Builder<static>|Property    withTrashed()
 * @method static Builder<static>|Property    withoutTrashed()
 *
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
        'features'          => 'array',
        'nearby_facilities' => 'array',
        'installment_plan'  => 'array',
        'best_selling'      => 'boolean',
        'today_deal'        => 'boolean',
        'approved'          => 'boolean',
        'latitude'          => 'float',
        'longitude'         => 'float',
    ];

    /**
     * Automatically include this attribute in toArray()/toJson().
     * Contains a single “representative” responsive-image URL (largest breakpoint).
     */
    protected $appends = ['property_image_url'];

    /**
     * Return the first responsive‐image URL (largest breakpoint) or fallback to original.
     * If neither exists, use a generic placeholder.
     */
    public function getPropertyImageUrlAttribute(): string
    {
        // 1) Try the single-file “property_image” collection:
        $media = $this->getFirstMedia('property_image');
        if ($media) {
            $urls = $media->getResponsiveImageUrls();
            return collect($urls)->last() ?? $media->getUrl();
        }

        // 2) FALLBACK: if no “property_image”, look for the first “gallery” item
        $firstGallery = $this->getMedia('gallery')->first();
        if ($firstGallery) {
            $responsive = $firstGallery->getResponsiveImageUrls();
            return collect($responsive)->last() ?? $firstGallery->getUrl();
        }

        // 3) If still nothing, ultimate fallback:
        return asset('assets/admin/images/error.png');
    }


    /**
     * Register the media collections:
     *   • property_image → single file + responsive images
     *   • gallery        → multiple files + responsive images
     */
    public function registerMediaCollections(?Media $media = null): void
    {
        $this
            ->addMediaCollection('property_image')
            ->singleFile()
            ->withResponsiveImages();

        $this
            ->addMediaCollection('gallery')
            ->withResponsiveImages();
    }

    /**
     * We do NOT register any custom conversions here,
     * because we rely solely on Spatie’s responsive‐image breakpoints.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Intentionally empty
    }

    /**
     * Relationship: this property belongs to a User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: this property belongs to a Society.
     */
    public function society(): BelongsTo
    {
        return $this->belongsTo(Society::class);
    }

    /**
     * Relationship: this property belongs to a SubSector (nullable).
     */
    public function subsector(): BelongsTo
    {
        return $this->belongsTo(SubSector::class);
    }
}
