<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class Property
 * 
 * Represents a real estate listing. Uses Spatie Media Library for responsive images.
 *
 * @property int $id
 * @property int $user_id
 * @property int $society_id
 * @property int|null $sub_sector_id
 * @property string $purpose
 * @property string|null $property_type
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
 * @property string|null $rent_type
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
 * @property-read array<int,string> $property_image_responsive
 * @property-read string $property_image_url
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Society $society
 * @property-read \App\Models\SubSector|null $subsector
 * @property-read \App\Models\User $user
 * @method static Builder<static>|Property approved()
 * @method static Builder<static>|Property bestSelling()
 * @method static Builder<static>|Property enabled()
 * @method static Builder<static>|Property featured()
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

    /**
     * Mass-assignable fields.
     *
     * @var array<int, string>
     */
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

    /**
     * Attribute type casts.
     *
     * @var array<string, string>
     */
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
     * Accessors that should be appended automatically.
     *
     * @var array<int, string>
     */
    protected $appends = ['property_image_url', 'property_image_responsive'];

    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * Property belongs to a user (agent/admin).
     *
     * @return BelongsTo<User,Property>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Property belongs to a society.
     *
     * @return BelongsTo<Society,Property>
     */
    public function society(): BelongsTo
    {
        return $this->belongsTo(Society::class);
    }

    /**
     * Property belongs to a subsector (nullable).
     *
     * @return BelongsTo<SubSector,Property>
     */
    public function subsector(): BelongsTo
    {
        return $this->belongsTo(SubSector::class);
    }

    /* -----------------------------------------------------------------
     |  Scopes
     | -----------------------------------------------------------------
     */

    /**
     * Scope: only enabled (public) records.
     *
     * @param  Builder<Property>  $query
     * @return Builder<Property>
     */
    public function scopeEnabled(Builder $query): Builder
    {
        return $query->where('status', 'enabled');
    }

    /**
     * Scope: only approved records.
     *
     * @param  Builder<Property>  $query
     * @return Builder<Property>
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('approved', true);
    }

    /**
     * Scope: best selling.
     *
     * @param  Builder<Property>  $query
     * @return Builder<Property>
     */
    public function scopeBestSelling(Builder $query): Builder
    {
        return $query->where('best_selling', true);
    }

    /**
     * Scope: "featured" logic.
     * Treat any of best_selling | today_deal | explicit featured flags (if present) as featured.
     *
     * @param  Builder<Property>  $query
     * @return Builder<Property>
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where('best_selling', true)
                ->orWhere('today_deal', true);

            // If you also have is_featured/featured columns, include them safely:
            $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
            if (in_array('is_featured', $columns, true)) {
                $q->orWhere('is_featured', true);
            }
            if (in_array('featured', $columns, true)) {
                $q->orWhere('featured', true);
            }
        });
    }

    /* -----------------------------------------------------------------
     |  Media Collections / Conversions
     | -----------------------------------------------------------------
     */

    /**
     * Register media collections.
     * - property_image: single file, responsive images
     * - gallery: multiple files, responsive images
     *
     * @param  Media|null  $media
     * @return void
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
     * We rely on Spatie's responsive images; no custom conversions here.
     *
     * @param  Media|null  $media
     * @return void
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Intentionally left empty
    }

    /* -----------------------------------------------------------------
     |  Accessors (URLs normalized to absolute for advice.local / advice.pk)
     | -----------------------------------------------------------------
     */

    /**
     * Get a single representative image URL for the card (largest responsive breakpoint or original).
     *
     * @return string
     */
    public function getPropertyImageUrlAttribute(): string
    {
        // 1) Try primary collection
        $media = $this->getFirstMedia('property_image');
        if ($media) {
            $urls = $media->getResponsiveImageUrls();
            $candidate = Arr::last($urls) ?: $media->getUrl();
            return $this->normalizeToAbsoluteUrl($candidate);
        }

        // 2) Fallback: first item from gallery
        $gallery = $this->getMedia('gallery')->first();
        if ($gallery) {
            $urls = $gallery->getResponsiveImageUrls();
            $candidate = Arr::last($urls) ?: $gallery->getUrl();
            return $this->normalizeToAbsoluteUrl($candidate);
        }

        // 3) Ultimate fallback
        return $this->normalizeToAbsoluteUrl(asset('assets/admin/images/property/placeholder.jpg'));
    }

    /**
     * Get all responsive URLs of the representative image (largest → smallest),
     * always absolute URLs. Useful for <img srcset> or debugging.
     *
     * @return array<int,string>
     */
    public function getPropertyImageResponsiveAttribute(): array
    {
        // 1) Try primary collection
        $media = $this->getFirstMedia('property_image');
        if ($media) {
            $urls = $media->getResponsiveImageUrls();
            if (!empty($urls)) {
                return array_values(array_map(fn($u) => $this->normalizeToAbsoluteUrl($u), $urls));
            }
            return [ $this->normalizeToAbsoluteUrl($media->getUrl()) ];
        }

        // 2) Fallback: first from gallery
        $gallery = $this->getMedia('gallery')->first();
        if ($gallery) {
            $urls = $gallery->getResponsiveImageUrls();
            if (!empty($urls)) {
                return array_values(array_map(fn($u) => $this->normalizeToAbsoluteUrl($u), $urls));
            }
            return [ $this->normalizeToAbsoluteUrl($gallery->getUrl()) ];
        }

        // 3) Fallback to placeholder only
        return [ $this->normalizeToAbsoluteUrl(asset('assets/admin/images/property/placeholder.jpg')) ];
    }

    /**
     * Normalize a possibly relative URL (e.g., `/storage/...`) to an absolute one using APP_URL.
     * Works for local (`http://advice.local`) and production (`https://advice.pk`) without code changes.
     *
     * @param  string  $url
     * @return string
     */
    protected function normalizeToAbsoluteUrl(string $url): string
    {
        if (Str::startsWith($url, ['http://', 'https://'])) {
            return $url;
        }

        // Prefer APP_URL, fallback to current request host if available.
        $base = rtrim(config('app.url') ?: (url('/')), '/');

        // Ensure $url begins with a single leading slash
        $path = '/' . ltrim($url, '/');

        return $base . $path;
    }
}
