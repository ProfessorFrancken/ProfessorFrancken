<?php

declare(strict_types=1);

namespace Francken\Features;

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use Laravel\BrowserKitTesting\TestCase as LaravelTestCase;

abstract class TestCase extends LaravelTestCase
{
    public array $connectionsToTransact = [null, 'francken-legacy'];

    /**
     * The base URL to use while testing the application.
     */
    protected string $baseUrl = 'http://localhost';

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
