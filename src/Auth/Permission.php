<?php

declare(strict_types=1);

namespace Francken\Auth;

use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * Francken\Auth\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Francken\Auth\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Francken\Auth\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Francken\Auth\Account[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Auth\Permission whereUpdatedAt($value)
 */
final class Permission extends SpatiePermission
{
}
