<?php

declare(strict_types=1);

namespace Francken\Features;

use Illuminate\Contracts\Console\Kernel;
use Laravel\BrowserKitTesting\TestCase as LaravelTestCase;

class TestCase extends LaravelTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
