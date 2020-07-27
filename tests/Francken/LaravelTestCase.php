<?php

declare(strict_types=1);

namespace Francken\Tests;

use Francken\Tests\Association\Newsletter\NullDriver;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase;
use Spatie\Newsletter\Newsletter;

abstract class LaravelTestCase extends TestCase
{
    /**
     * @var string[]|null[]
     */
    public array $connectionsToTransact = [null, 'francken-legacy'];

    /**
     * Creates the application.
     */
    public function createApplication() : Application
    {
        $app = require __DIR__ . '/../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $app->singleton(Newsletter::class, function () : NullDriver {
            return new NullDriver();
        });

        return $app;
    }
}
