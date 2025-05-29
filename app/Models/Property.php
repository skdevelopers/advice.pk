<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Society $society
 * @property-read \App\Models\SubSector|null $subsector
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereBestSelling($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereExtraData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereInstallmentPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMapEmbed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereNearbyFacilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePlotDimensions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePlotNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePlotSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePropertyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereRent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereRentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereShortVideoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereSocietyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereSubSectorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereTodayDeal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereVideoEmbed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property withoutTrashed()
 * @mixin \Eloquent
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
    /**
     * Register media collections for the property.
     *
     * - Main_image: Single featured image
     * - gallery: Multiple images of the property
     * - documents: Legal or layout files
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_image')->singleFile();
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('documents');
    }

}
