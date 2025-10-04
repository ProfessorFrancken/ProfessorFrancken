<?php

declare(strict_types=1);

namespace Francken\Auth;

use Francken\Association\Committees\Committee;
use Spatie\Permission\Models\Role as SpatieRole;
use Webmozart\Assert\Assert;

/**
 * Francken\Auth\Role
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Account[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Role whereUpdatedAt($value)
 */
final class Role extends SpatieRole
{
    public const ADMIN = 'Admin';

    public static function fromCommittee(Committee $committee) : self
    {
        /** @var Role $role */
        $role = self::firstOrCreate([
            'name' => 'Committee ' . $committee->name,
        ]);

        Assert::isInstanceOf($role, self::class);

        return $role;
    }
}
