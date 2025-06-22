<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'domain',
        'title',
        'slug',
        'heading',
        'meta_keywords',
        'meta_description',
        'description',
        'longitude',
        'latitude',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Register Media Collections
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('images')
            ->useDisk('public')
            ->useFallbackUrl('assets/admin/images/property/placeholder.jpg');

        $this
            ->addMediaCollection('floor_plan')
            ->useDisk('public');
    }

    /**
     * Register Media Conversions (For Responsive Images / WebP, etc.)
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('webp')
            ->width(800) // Adjust this as needed
            ->format('webp')
            ->nonQueued();
    }
}
