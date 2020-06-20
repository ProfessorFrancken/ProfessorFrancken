<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use Broadway\EventSourcing\EventSourcingRepository;
use Francken\Application\Committees\CommitteesList;
use Francken\Application\Committees\CommitteesListProjector;
use Francken\Application\Committees\CommitteesListRepository;
use Francken\Application\FranckenVrij\Edition;
use Francken\Application\FranckenVrij\FranckenVrijRepository;
use Francken\Application\ReadModel\MemberList\MemberList;
use Francken\Application\ReadModel\MemberList\MemberListRepository;
use Francken\Application\ReadModelRepository;
use Francken\Domain\Committees\Committee;
use Francken\Domain\Committees\CommitteeRepository;
use Francken\Domain\Members\Member;
use Francken\Domain\Members\MemberRepository;
use Francken\Domain\Posts\Post;
use Francken\Domain\Posts\PostRepository;
use Francken\Infrastructure\EventSourcing\Factory;
use Francken\Infrastructure\Repositories\IlluminateRepository;
use Francken\Shared\Clock\Clock;
use Francken\Shared\Clock\SystemClock;
use Francken\Shared\Settings\Settings;
use Francken\Shared\Settings\ValueStoreSettings;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\ConnectionInterface as DatabaseConnection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;
use Spatie\Valuestore\Valuestore;

final class AppServiceProvider extends ServiceProvider
{
    // This constant contains all the repositories we want to register,
    // it contains pairs of the repository's class and the associated
    // aggregate's class name
    public const EVENT_SOURCED_REPOSITORIES = [
        [CommitteeRepository::class, Committee::class],
        [MemberRepository::class, Member::class],
        [PostRepository::class, Post::class],
    ];

    // Similarly we can register illuminate read models by again providing a pair
    // where the first value is the repository's class name and the second value
    // are the options that should be given to the illuminate repository
    public const ILLUMINATE_READ_MODELS = [
        [
            MemberListRepository::class,
            ['members', MemberList::class, 'id']
        ],
        [
            CommitteesListRepository::class,
            ['committees_list', CommitteesList::class, 'id', ['members']]
        ],
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
     * Francken\Infrastructure\EventSourcing\Factory class
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

        $this->app->bind(ReadModelRepository::class, \Francken\Infrastructure\Repositories\InMemoryRepository::class);

        // In this case we don't want Laravel to resolve the CommonMarkConverter since
        // this would mean that Laravel would provide the converter with an environment,
        // instead we want the converter to create its own environment object
        $this->app->when(CommitteesListProjector::class)
            ->needs(CommonMarkConverter::class)
            ->give(function () {
                return new CommonMarkConverter();
            });
    }
}
