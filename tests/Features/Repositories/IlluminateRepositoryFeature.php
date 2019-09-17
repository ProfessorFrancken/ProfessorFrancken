<?php

declare(strict_types=1);

namespace Francken\Features\Repositories;

use Francken\Application\ReadModelRepository;
use Francken\Infrastructure\Repositories\IlluminateRepository;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\ConnectionInterface as Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Schema;

class IlluminateRepositoryFeature extends RepositoryTestCase
{
    /** @var Application|null $app */
    private $app;

    /** @var Kernel */
    private $kernel;

    /**
     * Setup the App
     */
    protected function setUp() : void
    {
        parent::setUp();

        putenv('APP_ENV=testing');
        $this->app = require __DIR__ . '/../../../bootstrap/app.php';

        /** @var Kernel $kernel */
        $this->kernel = $this->app->make(Kernel::class);
        $this->kernel->bootstrap();
        $this->kernel->call('migrate');

        Schema::create('testing_table', function (Blueprint $table) : void {
            $table->string('id');
            $table->string('first');
            $table->string('second');
        });
    }

    protected function tearDown() : void
    {
        Schema::drop('testing_table');
        $this->kernel->call('migrate:rollback');
        $this->app->flush();
        $this->app = null;
        parent::tearDown();
    }

    protected function createRepository() : ReadModelRepository
    {
        $connection = $this->app->make(Connection::class);
        return new IlluminateRepository(
            $connection,
            'testing_table',
            TestReadModel::class,
            'id'
        );
    }
}
