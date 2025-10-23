<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * 
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $slug SEO slug like nova-city-islamabad
 * @property string $title
 * @property string $heading
 * @property string $detail
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property string $domain Domain the page belongs to, e.g., advice.pk
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage whereHeading($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocietyPage withoutTrashed()
 * @mixin \Eloquent
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
