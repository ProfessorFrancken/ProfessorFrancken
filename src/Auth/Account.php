<?php

declare(strict_types=1);

namespace Francken\Auth;

// use Illuminate\Foundation\Auth\User as Authenticatable;
use Francken\Domain\Members\MemberId;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Spatie\Permission\Traits\HasRoles;

final class Account extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use MustVerifyEmail;

    use HasRoles;

    protected $guard_name = 'web';

    protected $table = 'auth_accounts';

    protected $fillable = [
        'email',
        'password',
        'member_id',
    ];

    public function scopeOfMember(Builder $query, MemberId $memberId) : Builder
    {
        // If we do want to have users that can represent members, alumni and
        // companies, then we could add an additional type check
        return $query->whereMemberId((string) $memberId);
    }
}
