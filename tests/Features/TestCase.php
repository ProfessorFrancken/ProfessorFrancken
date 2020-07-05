<?php

declare(strict_types=1);

namespace Francken\Features;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
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
    public function createApplication() : Application
    {
        $app = require __DIR__ . '/../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
