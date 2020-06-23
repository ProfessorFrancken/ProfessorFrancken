<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use Broadway\EventSourcing\EventSourcingRepository;
use Francken\Association\FranckenVrij\Edition;
use Francken\Association\FranckenVrij\FranckenVrijRepository;
use Francken\Shared\Clock\Clock;
use Francken\Shared\Clock\SystemClock;
use Francken\Shared\EventSourcing\Factory;
use Francken\Shared\ReadModelRepository;
use Francken\Shared\Repositories\IlluminateRepository;
use Francken\Shared\Repositories\InMemoryRepository;
use Francken\Shared\Settings\Settings;
use Francken\Shared\Settings\ValueStoreSettings;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\ConnectionInterface as DatabaseConnection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Spatie\Valuestore\Valuestore;

final class AppServiceProvider extends ServiceProvider
{
    // This constant contains all the repositories we want to register,
    // it contains pairs of the repository's class and the associated
    // aggregate's class name
    public const EVENT_SOURCED_REPOSITORIES = [
    ];

    // Similarly we can register illuminate read models by again providing a pair
    // where the first value is the repository's class name and the second value
    // are the options that should be given to the illuminate repository
    public const ILLUMINATE_READ_MODELS = [
        [
            FranckenVrijRepository::class,
            ['francken_vrij', Edition::class, 'id']
        ],
    ];

    /**
     * Register any application services.
     */
    public function register() : void
    {
        // Register the event sourced repositories
        foreach (static::EVENT_SOURCED_REPOSITORIES as $repository) {
            $this->registerRepository($repository[0], $repository[1]);
        }

        // Register read model repositories and other associated services
        $this->registerReadModels();

        $this->app->instance('path', 'src');


        $this->app->bind(ValueStore::class, function () {
            return ValueStore::make(
                storage_path('app/settings.json')
            );
        });
        $this->app->bind(Settings::class, ValueStoreSettings::class);
        $this->app->bind(Clock::class, SystemClock::class);
    }

    public function boot() : void
    {
        Paginator::defaultView('components.pagination.default');

        Paginator::defaultSimpleView('components.pagination.simple-default');
    }

    /**
     * Register the repositorie used to store our event sourced aggregate root
     * Currently all repositories use the same configuration based on the
     * Francken\Shared\EventSourcing\Factory class
     *
     * @param string $repository classname
     * @param string $aggregate  classname
     */
    private function registerRepository(string $repository, string $aggregate) : void
    {
        $this->app->when($repository)
            ->needs(EventSourcingRepository::class)
            ->give(function (Application $app) use ($aggregate) {
                $factory = $app->make(Factory::class);

                return $factory->buildForAggregate($aggregate);
            });
    }

    /**
     * Register bindings to get specific Illuminate repositories for our read models
     */
    private function registerReadModels() : void
    {
        // Register all read models
        foreach (static::ILLUMINATE_READ_MODELS as $readModel) {
            $repository = $readModel[0];
            $options = $readModel[1];

            // Return an illuminate repository when a ReadModelRepository is asked
            // Pass all options (such as table name, ReadModel class, and primary key)
            // directly to the illuminate repository
            $this->app->when($repository)
                ->needs(ReadModelRepository::class)
                ->give(
                    function (Application $app) use ($options) {
                        return new IlluminateRepository(
                            $app->make(DatabaseConnection::class),
                            ...$options
                        );
                    }
                );
        }

        $this->app->bind(ReadModelRepository::class, InMemoryRepository::class);
    }
}
