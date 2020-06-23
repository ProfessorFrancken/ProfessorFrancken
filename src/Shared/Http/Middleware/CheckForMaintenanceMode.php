Middleware?php

declare(strict_types=1);

namespace Francken\Shared\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;

class CheckForMaintenanceMode extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array<array-key, mixed>
     */
    protected $except = [
        //
    ];
}
void