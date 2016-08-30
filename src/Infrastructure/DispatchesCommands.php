<?php

declare(strict_types=1);

namespace Francken\Infrastructure;

use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * We are using a "base" dispatches commands trait so that if in
 * the future we decide to switch to Tactician for our command
 * bus, we won't have to change all of the controllers using
 * the DispatchesJobs trait
 */
trait DispatchesCommands
{
    use DispatchesJobs;
}
