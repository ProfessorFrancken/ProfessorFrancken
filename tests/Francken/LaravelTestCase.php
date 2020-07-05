<?php

declare(strict_types=1);

namespace Francken\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase;

abstract class LaravelTestCase extends TestCase
{
    public array $connectionsToTransact = [null, 'francken-legacy'];

    /**
     * Creates the application.
     */
    public function createApplication(): Application
    {
        $app = require __DIR__ . '/../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
