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
 * @property string $heading
 * @property string $detail
 * @property string $title
 * @property string $slug
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property string $domain
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
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
