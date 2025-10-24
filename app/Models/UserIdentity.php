<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;


/**
 * UserIdentity model
 *
 * Links a local user to a third-party identity (Eventbrite), storing provider
 * user id and OAuth tokens. Keeps auth concerns separated from the User model.
 *
 * @property int                         $id
 * @property int                         $user_id
 * @property string                      $provider         'eventbrite'
 * @property string                      $provider_id      Eventbrite user id
 * @property string|null                 $access_token
 * @property string|null                 $refresh_token
 * @property Carbon|null $token_expires_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */



/**
 *
 *
 * @property-read User|null $user
 * @method static Builder<static>|UserIdentity newModelQuery()
 * @method static Builder<static>|UserIdentity newQuery()
 * @method static Builder<static>|UserIdentity query()
 * @mixin Eloquent
 */
class UserIdentity extends Model
{
    /** @var array<int,string> */
    protected $fillable = [
        'user_id','provider','provider_id',
        'access_token','refresh_token','token_expires_at',
    ];

    /** @var array<string,string> */
    protected $casts = [
        'token_expires_at' => 'datetime',
    ];

    /**
     * Back-reference to the owning User.
     *
     * @return BelongsTo<User,UserIdentity>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');

    }

}
