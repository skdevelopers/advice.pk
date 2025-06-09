<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property int $user_id
 * @property string $slug
 * @property string $title
 * @property string $heading
 * @property string $detail
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property string $domain
 * @property-read User|null $user
 */
class SocietyPage extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'user_id', 'slug', 'title', 'heading', 'detail',
        'meta_keywords', 'meta_description', 'domain',
    ];

    /**
     * Get the user who created this page.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
