<?php

declare(strict_types=1);

namespace Francken\Auth;

use Francken\Association\LegacyMember;
use Francken\Domain\Members\MemberId;
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

    public function scopeOfMember(Builder $query, MemberId $memberId) : Builder
    {
        // If we do want to have users that can represent members, alumni and
        // companies, then we could add an additional type check
        return $query->whereMemberId((string) $memberId);
    }

    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class, 'member_id');
    }
}
