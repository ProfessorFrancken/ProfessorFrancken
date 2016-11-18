<?php

namespace Francken\Infrastructure;

use Francken\Application\ReadModelRepository;
use Broadway\EventSourcing\EventSourcingRepository;
use Francken\Application\Books\AvailableBook;
use Francken\Application\Books\AvailableBooksRepository;
use Francken\Application\Books\BookDetailsRepositoryI;
use Francken\Application\Committees\CommitteesList;
use Francken\Application\Committees\CommitteesListProjector;
use Francken\Application\Committees\CommitteesListRepository;
use Francken\Application\Members\Registration\RequestStatus;
use Francken\Application\Members\Registration\RequestStatusRepository;
use Francken\Application\ReadModel\MemberList\MemberList;
use Francken\Application\ReadModel\MemberList\MemberListRepository;
use Francken\Application\ReadModel\PostList\PostList;
use Francken\Application\ReadModel\PostList\PostListRepository;
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

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->registerAggregateRepositories();
        $this->registerReadModels();
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

    private function registerReadModels()
    {
        $this->app->when(MemberListRepository::class)
            ->needs(ReadModelRepository::class)
            ->give(function () {
                return $this->illuminateRepository('members', MemberList::class, 'id');
            });

        $this->app->when(CommitteesListRepository::class)
            ->needs(ReadModelRepository::class)
            ->give(function () {
                return $this->illuminateRepository('committees_list', CommitteesList::class, 'id', ['members']);
            });

        $this->app->when(PostListRepository::class)
            ->needs(ReadModelRepository::class)
            ->give(function () {
                return $this->illuminateRepository('posts', PostList::class, 'id');
            });

        $this->app->when(RequestStatusRepository::class)
            ->needs(ReadModelRepository::class)
            ->give(function () {
                return $this->illuminateRepository('request_status', RequestStatus::class, 'id');
            });

        $this->app->when(AvailableBooksRepository::class)
            ->needs(ReadModelRepository::class)
            ->give(function () {
                return $this->illuminateRepository('available_books', AvailableBook::class, 'id');
            });

        $this->app->bind(BookDetailsRepositoryI::class, BookDetailsRepository::class);

        $this->app->when(CommitteesListProjector::class)
            ->needs(CommonMarkConverter::class)
            ->give(function () {
                return new CommonMarkConverter();
            });
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
     * Creates a new binding for an event sourced aggregate repository.
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
}
