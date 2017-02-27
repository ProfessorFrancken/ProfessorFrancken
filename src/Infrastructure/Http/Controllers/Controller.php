<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use Francken\Infrastructure\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use DispatchesCommands;
}
