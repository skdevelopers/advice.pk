<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\Conversions\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class Blog
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string $heading
 * @property string $detail
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property string $domain
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\BlogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereHeading($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog withoutTrashed()
 * @mixin \Eloquent
 */
class Blog extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'heading',
        'detail',
        'title',
        'slug',
        'meta_keywords',
        'meta_description',
        'domain',
    ];

    /**
     * Register media collection for responsive images.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('blogs')
            ->useDisk('public')
            ->withResponsiveImages();
    }

    /**
     * Optional: convert to WebP for performance.
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format(\Spatie\Image\Manipulations::FORMAT_WEBP)
            ->performOnCollections('blogs');

        $this->addMediaConversion('jpg')
            ->format(\Spatie\Image\Manipulations::FORMAT_JPG)
            ->performOnCollections('blogs');
    }

    /**
     * Creator relationship.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
