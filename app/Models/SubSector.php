<?php

namespace App\Models;

use Database\Factories\SubSectorFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\SubSector
 *
 * @property int $id
 * @property int $society_id
 * @property int|null $parent_id
 * @property string|null $name
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $meta_keywords
 * @property string|null $meta_detail
 * @property string|null $detail
 * @property string|null $block
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, SubSector> $children
 * @property-read int|null $children_count
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read SubSector|null $parent
 * @property-read \App\Models\Society $society
 * @property-read \App\Models\SubSociety|null $subSociety
 * @method static \Database\Factories\SubSectorFactory factory($count = null, $state = [])
 * @method static Builder<static>|SubSector newModelQuery()
 * @method static Builder<static>|SubSector newQuery()
 * @method static Builder<static>|SubSector query()
 * @method static Builder<static>|SubSector whereBlock($value)
 * @method static Builder<static>|SubSector whereCreatedAt($value)
 * @method static Builder<static>|SubSector whereDeletedAt($value)
 * @method static Builder<static>|SubSector whereDetail($value)
 * @method static Builder<static>|SubSector whereId($value)
 * @method static Builder<static>|SubSector whereMetaDetail($value)
 * @method static Builder<static>|SubSector whereMetaKeywords($value)
 * @method static Builder<static>|SubSector whereName($value)
 * @method static Builder<static>|SubSector whereParentId($value)
 * @method static Builder<static>|SubSector whereSlug($value)
 * @method static Builder<static>|SubSector whereSocietyId($value)
 * @method static Builder<static>|SubSector whereTitle($value)
 * @method static Builder<static>|SubSector whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SubSector extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * Mass-assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'society_id',
        'parent_id',
        'name',
        'title',
        'slug',
        'meta_keywords',
        'meta_detail',
        'detail',
        'block',
    ];

    /**
     * Register a single-file “sub_sector_image” collection with responsive variants.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('sub_sector_image')
            ->useDisk('public')
            ->withResponsiveImages()
            ->singleFile();
    }

    /**
     * (Optional) Add a thumb conversion.
     *
     * @param  Media|null  $media
     * @return void
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(200)
            ->height(150)
            ->keepOriginalImageFormat()
            ->performOnCollections('sub_sector_image')
            ->nonQueued();
    }

    /**
     * SubSector → Third-level items Children.
     *
     * @return Builder|SubSector|HasMany
     */
    public function children(): Builder|SubSector|HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * SubSector → Second-level or top-level
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * SubSector → Society
     */
    public function society(): BelongsTo
    {
        return $this->belongsTo(Society::class);
    }

    /**
     * SubSector → SubSociety (optional nesting)
     */
    public function subSociety(): BelongsTo
    {
        return $this->belongsTo(SubSociety::class, 'sub_society_id');
    }
}
