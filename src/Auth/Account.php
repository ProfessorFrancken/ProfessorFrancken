<?php

declare(strict_types=1);

namespace Francken\Auth;

use Francken\Association\LegacyMember;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Francken\Auth\Account
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property int $member_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Francken\Association\LegacyMember $member
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Account ofMember($member_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Account permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Account role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Account whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Account whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Account wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Account whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Account whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class Account extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use Notifiable;

    use HasRoles;

    protected $guard_name = 'web';

    protected $table = 'auth_accounts';

    protected $fillable = [
        'email',
        'password',
        'member_id',
    ];

    public static function activate(
        string $member_id,
        string $email,
        string $password
    ) : self {
        $account = self::create([
            'member_id' => $member_id,
            'email' => $email,
            'password' => $password
        ]);

        event(new AccountWasActivated($account));

        return $account;
    }

    public function scopeOfMember(Builder $query, int $member_id) : Builder
    {
        // If we do want to have users that can represent members, alumni and
        // companies, then we could add an additional type check
        return $query->whereMemberId($member_id);
    }

    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class, 'member_id');
    }
}
