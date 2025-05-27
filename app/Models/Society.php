<?php

namespace App\Models;

use Database\Factories\SocietyFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Society
 *
 * @property int $id
 * @property int $user_id
 * @property int $city_id
 * @property string $name
 * @property string $slug
 * @property string|null $overview
 * @property string|null $detail
 * @property bool $has_residential_plots
 * @property bool $has_commercial_plots
 * @property bool $has_houses
 * @property bool $has_apartments
 * @property bool $has_farm_houses
 * @property bool $has_shop
 * @property array|null $property_types
 * @property int $created_by
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read City $city
 * @property-read User $user
 * @property-read User|null $creator
 * @property-read Collection<int, SubSector> $subSectors
 * @property-read int|null $sub_sectors_count
 * @property-read MediaCollection<int, Media> $media
 *
 * @method static SocietyFactory factory($count = null, $state = [])
 * @method static Builder|Society newModelQuery()
 * @method static Builder|Society newQuery()
 * @method static Builder|Society query()
 * @method static Builder|Society whereStatus($value)
 * @method static Builder|Society onlyTrashed()
 * @method static Builder|Society withTrashed()
 * @method static Builder|Society withoutTrashed()
 * @mixin Eloquent
 */
class Society extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    /**
     * Mass-assignable attributes.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'city_id',
        'user_id',
        'overview',
        'detail',
        'status',
        'has_residential_plots',
        'has_commercial_plots',
        'has_houses',
        'has_apartments',
        'has_farm_houses',
        'has_shop',
        'property_types',
        'created_by',
    ];

    /**
     * Attribute casting.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'has_residential_plots' => 'boolean',
        'has_commercial_plots'  => 'boolean',
        'has_houses'            => 'boolean',
        'has_apartments'        => 'boolean',
        'has_farm_houses'       => 'boolean',
        'has_shop'              => 'boolean',
        'property_types'        => 'array',
    ];

    /**
     * Register media collections:
     * - society_image (single, responsive)
     * - banner (single, responsive)
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('society_image')
            ->useDisk('public')
            ->withResponsiveImages()
            ->singleFile();

        $this
            ->addMediaCollection('banner')
            ->useDisk('public')
            ->withResponsiveImages()
            ->singleFile();
    }

    /**
     * (Optional) Add a custom “thumb” conversion if you need one in addition
     * to responsive images. Otherwise, you can omit this method.
     *
     * @param  Media|null  $media
     * @return void
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->keepOriginalImageFormat()
            ->performOnCollections('society_image', 'banner')
            ->nonQueued();
    }
    /**
     * Society → SubSociety (optional nesting)
     */
    public function subSociety(): BelongsTo
    {
        return $this->belongsTo(SubSociety::class, 'sub_society_id');
    }

    /**
     * Society → SubSectors.
     */
    public function subSectors(): HasMany
    {
        return $this->hasMany(SubSector::class);
    }

    /**
     * Society → City.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Society → Assigned User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Society → Creator (admin who added it).
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
