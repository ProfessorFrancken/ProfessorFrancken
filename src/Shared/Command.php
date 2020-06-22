<?php

declare(strict_types=1);

namespace Francken\Shared;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class Command implements ShouldQueue
{
    use Queueable;
}
