<?php

declare(strict_types=1);

namespace Francken\Auth;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Spatie\Permission\Models\Role as SpatieRole;
use Webmozart\Assert\Assert;

final class Role extends SpatieRole
{
    public static function fromCommittee(Committee $committee) : self
    {
        /** @var Role $role */
        $role = self::firstOrCreate([
            'name' => 'Committee ' . $committee->name,
        ]);

        Assert::isInstanceOf($role, self::class);

        return $role;
    }

    public static function fromBoard(Board $board) : self
    {
        /** @var Role $role */
        $role = self::firstOrCreate([
            'name' => 'Board',
        ]);

        Assert::isInstanceOf($role, self::class);

        return $role;
    }
}
