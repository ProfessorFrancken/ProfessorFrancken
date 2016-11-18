<?php

namespace Francken\Infrastructure;

use Broadway\EventSourcing\EventSourcingRepository;
use Francken\Application\Books\AvailableBook;
use Francken\Application\Books\AvailableBooksProjector;
use Francken\Application\Books\BookDetailsRepositoryI;
use Francken\Application\Committees\CommitteesList;
use Francken\Application\Committees\CommitteesListProjector;
use Francken\Application\Members\Registration\RequestStatus;
use Francken\Application\Members\Registration\RequestStatusProjector;
use Francken\Application\ReadModel\MemberList\MemberList;
use Francken\Application\ReadModel\MemberList\MemberListProjector;
use Francken\Application\ReadModel\PostList\PostList;
use Francken\Application\ReadModel\PostList\PostListProjector;
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
use Francken\Infrastructure\Http\Controllers\Admin\RegistrationRequestsController;
use Francken\Infrastructure\Http\Controllers\BookController;
use Francken\Infrastructure\Http\Controllers\CommitteeController;
use Francken\Infrastructure\Repositories\IlluminateRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\ConnectionInterface as DatabaseConnection;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAggregateRepositories();
        $this->registerReadModels();
        $this->registerControllers();
        $this->app->instance('path', 'src/Infrastructure');
    }

    private function registerAggregateRepositories()
    {
        $this->registerRepository(BookRepository::class, Book::class);
        $this->registerRepository(CommitteeRepository::class, Committee::class);
        $this->registerRepository(MemberRepository::class, Member::class);
        $this->registerRepository(PostRepository::class, Post::class);
        $this->registerRepository(RegistrationRequestRepository::class, RegistrationRequest::class);
    }

    private function registerControllers()
    {
        $this->app->bind(
            CommitteeController::class,
            function (Application $app) {
                return new CommitteeController(
                    $this->illuminateRepository('committees_list', CommitteesList::class, 'id', ['members']));
            }
        );

        $this->app->bind(
            RegistrationRequestsController::class,
            function (Application $app) {
                return new RegistrationRequestsController(
                    $this->illuminateRepository('request_status', RequestStatus::class, 'id')
                );
            }
        );
        $this->app->bind(
            BookController::class,
            function (Application $app) {
                return new BookController(
                    $this->illuminateRepository('available_books', AvailableBook::class, 'id')
                );
            }
        );
    }

    private function registerReadModels()
    {
        $this->app->bind(BookDetailsRepositoryI::class, BookDetailsRepository::class);

        $this->app->singleton(
            MemberListProjector::class,
            function (Application $app) {
                return new MemberListProjector(
                    $this->illuminateRepository('members', MemberList::class, 'id')
                );
            }
        );

        $this->app->singleton(
            CommitteesListProjector::class,
            function (Application $app) {
                return new CommitteesListProjector(
                    $this->illuminateRepository('committees_list', CommitteesList::class, 'id', ['members']),
                    $this->illuminateRepository('members', MemberList::class, 'id'),
                    new CommonMarkConverter()
                );
            }
        );

        $this->app->singleton(
            PostListProjector::class,
            function (Application $app) {
                return new PostListProjector(
                    $this->illuminateRepository('posts', PostList::class, 'id')
                );
            }
        );

        $this->app->singleton(
            RequestStatusProjector::class,
            function (Application $app) {
                return new RequestStatusProjector(
                    $this->illuminateRepository('request_status', RequestStatus::class, 'id')
                );
            }
        );
        $this->app->singleton(
            AvailableBooksProjector::class,
            function (Application $app) {
                return new AvailableBooksProjector(
                    $this->illuminateRepository('available_books', AvailableBook::class, 'id'),
                    new BookDetailsRepository
                );
            }
        );
    }

    private function illuminateRepository(string $tableName, string $modelName, string $identifier, array $stringify = []) : IlluminateRepository
    {
        return new IlluminateRepository(
            $this->app->make(DatabaseConnection::class),
            $tableName,
            $modelName,
            $identifier,
            $stringify
        );
    }

    /**
     * Creates a new binding for an event sourced aggregate repository
     * @param string $repository classname
     * @param string $aggregate classname
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
}
