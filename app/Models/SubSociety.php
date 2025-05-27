<?php

namespace App\Models;

use Database\Factories\SubSocietyFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\SubSociety
 *
 * @property int $id
 * @property int $society_id
 * @property string $name
 * @property string $slug
 * @property string|null $type
 * @property string|null $meta_keywords
 * @property string|null $meta_detail
 * @property string|null $detail
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Society $society
 * @property-read Collection<int,SubSector> $subSectors
 *
 * @method static SubSocietyFactory factory($count = null, $state = [])
 * @method static Builder|SubSociety newModelQuery()
 * @method static Builder|SubSociety newQuery()
 * @method static Builder|SubSociety query()
 * @mixin Eloquent
 */
class SubSociety extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    /**
     * Mass-assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'society_id',
        'name',
        'slug',
        'type',
        'meta_keywords',
        'meta_detail',
        'detail',
    ];

    /**
     * Register a gallery or single-file if needed.
     *
     * Here we demonstrate a single “subsociety_image” with responsive images:
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('subsociety_image')
            ->useDisk('public')
            ->withResponsiveImages()
            ->singleFile();
    }

    /**
     * (Optional) Add a thumb conversion.
     *
     * @param Media|null $media
     * @return void
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(250)
            ->height(180)
            ->keepOriginalImageFormat()
            ->performOnCollections('subsociety_image')
            ->nonQueued();
    }

    /**
     * SubSociety → Society
     */
    public function society(): BelongsTo
    {
        return $this->belongsTo(Society::class);
    }

    /**
     * SubSociety → SubSectors
     */
    public function subSectors(): HasMany
    {
        return $this->hasMany(SubSector::class, 'sub_society_id');
    }
}
