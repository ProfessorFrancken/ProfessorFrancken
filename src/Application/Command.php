<?php

declare(strict_types=1);

namespace Francken\Application;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class Command implements ShouldQueue
{
    use Queueable;
}
