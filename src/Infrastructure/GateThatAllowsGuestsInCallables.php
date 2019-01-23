<?php

declare(strict_types=1);

namespace Francken\Infrastructure;

use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

final class GateThatAllowsGuestsInCallables extends Gate implements GateContract
{
    /**
     * Resolve and call the appropriate authorization callback.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  string  $ability
     * @return bool
     */
    protected function callAuthCallback($user, $ability, array $arguments)
    {
        $callback = $this->resolveAuthCallback($user, $ability, $arguments);

        if (is_array($callback)) {
            $instance = $this->resolvePolicy($callback[0]);
            $method = $callback[1];
            return $instance->{$method}($user, ...$arguments);
        }

        return $callback($user, ...$arguments);
    }
}
