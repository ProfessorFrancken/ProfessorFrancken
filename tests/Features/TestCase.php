<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Tests\Association\Newsletter\NullDriver;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\BrowserKitTesting\TestCase as LaravelTestCase;
use Spatie\Newsletter\Newsletter;

abstract class TestCase extends LaravelTestCase
{
    use DatabaseMigrations;

    /**
     * @var string[]|null[]
     */
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

        $app->singleton(Newsletter::class, fn () : NullDriver => new NullDriver());

        return $app;
    }
}
