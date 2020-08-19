<?php

declare(strict_types=1);

namespace Francken\Auth;

use Francken\Association\Committees\Committee;
use Spatie\Permission\Models\Role as SpatieRole;
use Webmozart\Assert\Assert;

final class Role extends SpatieRole
{
    protected $guarded = [];

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
