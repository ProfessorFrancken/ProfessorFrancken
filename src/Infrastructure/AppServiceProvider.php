<?php

declare(strict_types=1);

namespace Francken\Infrastructure;

use Broadway\EventSourcing\EventSourcingRepository;
use Francken\Application\Books\AvailableBook;
use Francken\Application\Books\AvailableBooksRepository;
use Francken\Application\Books\BookDetailsRepositoryI;
use Francken\Application\Committees\CommitteesList;
use Francken\Application\Committees\CommitteesListProjector;
use Francken\Application\Committees\CommitteesListRepository;
use Francken\Application\FranckenVrij\Edition;
use Francken\Application\FranckenVrij\FranckenVrijRepository;
use Francken\Application\Members\Registration\RequestStatus;
use Francken\Application\Members\Registration\RequestStatusRepository;
use Francken\Application\ReadModel\MemberList\MemberList;
use Francken\Application\ReadModel\MemberList\MemberListRepository;
use Francken\Application\ReadModel\PostList\PostList;
use Francken\Application\ReadModel\PostList\PostListRepository;
use Francken\Application\ReadModelRepository;
use Francken\Domain\Books\Book;
use Francken\Domain\Books\BookRepository;
use Francken\Domain\Committees\Committee;
use Francken\Domain\Committees\CommitteeRepository;
use Francken\Domain\Members\Member;
use Francken\Domain\Members\MemberRepository;
use Francken\Domain\Members\Registration\RegistrationRequest;
use Francken\Domain\Members\Registration\RegistrationRequestRepository;
use Francken\Domain\Posts\Post;
use Francken\Domain\Posts\PostRepository;
use Francken\Infrastructure\Books\BookDetailsRepository;
use Francken\Infrastructure\EventSourcing\Factory;
use Francken\Infrastructure\Repositories\IlluminateRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\ConnectionInterface as DatabaseConnection;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;

final class AppServiceProvider extends ServiceProvider
{
    // This constant contains all the repositories we want to register,
    // it contains pairs of the repository's class and the associated
    // aggregate's class name
    const EVENT_SOURCED_REPOSITORIES = [
        [BookRepository::class, Book::class],
        [CommitteeRepository::class, Committee::class],
        [MemberRepository::class, Member::class],
        [PostRepository::class, Post::class],
        [RegistrationRequestRepository::class, RegistrationRequest::class],
    ];

    // Similarly we can register illuminate read models by again providing a pair
    // where the first value is the repository's class name and the second value
    // are the options that should be given to the illuminate repository
    const ILLUMINATE_READ_MODELS = [
        [
            MemberListRepository::class,
            ['members', MemberList::class, 'id']
        ],
        [
            CommitteesListRepository::class,
            ['committees_list', CommitteesList::class, 'id', ['members']]
        ],
        [
            PostListRepository::class,
            ['posts', PostList::class, 'id']
        ],
        [
            RequestStatusRepository::class,
            ['request_status', RequestStatus::class, 'id']
        ],
        [
            AvailableBooksRepository::class,
            ['available_books', AvailableBook::class, 'id']
        ],
        [
            FranckenVrijRepository::class,
            ['francken_vrij', Edition::class, 'id']
        ],
    ];

    /**
     * Register any application services.
     */
    public function register()
    {
        // Register the event sourced repositories
        foreach (static::EVENT_SOURCED_REPOSITORIES as $repository) {
            $this->registerRepository($repository[0], $repository[1]);
        }

        // Register read model repositories and other associated services
        $this->registerReadModels();

        $this->app->instance('path', 'src/Infrastructure');
    }

    /**
     * Register the repositorie used to store our event sourced aggregate root
     * Currently all repositories use the same configuration based on the
     * Francken\Infrastructure\EventSourcing\Factory class
     *
     * @param string $repository classname
     * @param string $aggregate  classname
     */
    private function registerRepository(string $repository, string $aggregate)
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
    private function registerReadModels()
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

        // Responsible for getting the book cover from Amazon
        $this->app->bind(BookDetailsRepositoryI::class, BookDetailsRepository::class);

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
