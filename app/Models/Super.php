<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property-read \App\Models\City|null $city
 * @method static \Database\Factories\SuperFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Super newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Super newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Super onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Super query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Super withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Super withoutTrashed()
 * @mixin \Eloquent
 */
class Super extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'supers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        // add your actual column names here, e.g.:
        // 'name', 'description', 'status', ...
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Example relationship: if Super belongsTo a City
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    // Add other relationships or scopes as needed.
}
