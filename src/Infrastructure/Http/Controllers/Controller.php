<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Francken\Infrastructure\DispatchesCommands;

class Controller extends BaseController
{
    use DispatchesCommands;
}
