<?php

declare(strict_types=1);

namespace Francken\Auth;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Spatie\Permission\Models\Role as SpatieRole;

final class Role extends SpatieRole
{
    public static function fromCommittee(Committee $committee) : self
    {
        return self::firstOrCreate([
            'name' => 'Committee ' . $committee->name,
        ]);
    }

    public static function fromBoard(Board $board) : self
    {
        return self::firstOrCreate([
            'name' => 'Board',
        ]);
    }
}
