<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $title
 * @property string $slug
 * @property string $heading
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property string|null $description
 * @property string|null $longitude
 * @property string|null $latitude
 */
class Project extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'user_id', 'domain', 'title', 'slug', 'heading',
        'meta_keywords', 'meta_description', 'description',
        'longitude', 'latitude',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('images')
            ->useDisk('public')
            ->useFallbackUrl('assets/admin/images/property/placeholder.jpg')
            ->useResponsiveImages();

        $this
            ->addMediaCollection('floor_plan') // replaces `floor_plan`
            ->useDisk('public');
    }
}

