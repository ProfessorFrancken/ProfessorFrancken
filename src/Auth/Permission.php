<?php

declare(strict_types=1);

namespace Francken\Auth;

use Spatie\Permission\Models\Permission as SpatiePermission;

final class Permission extends SpatiePermission
{
    protected $guarded = [];
}
