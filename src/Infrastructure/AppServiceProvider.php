<?php

namespace Francken\Infrastructure;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\AggregateFactoryInterface;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;
use Francken\Application\ReadModel\CommitteesList\CommitteesList;
use Francken\Application\ReadModel\CommitteesList\CommitteesListProjector;
use Francken\Application\ReadModel\MemberList\MemberList;
use Francken\Application\ReadModel\MemberList\MemberListProjector;
use Francken\Domain\Committees\Committee;
use Francken\Domain\Committees\CommitteeRepository;
use Francken\Domain\Members\Member;
use Francken\Domain\Members\MemberRepository;
use Francken\Domain\Members\Registration\RegistrationRequest;
use Francken\Domain\Members\Registration\RegistrationRequestRepository;
use Francken\Domain\Posts\Post;
use Francken\Domain\Posts\PostRepository;
use Francken\Infrastructure\Repositories\IlluminateRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\ConnectionInterface as DatabaseConnection;
use Illuminate\Support\ServiceProvider;

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
        $this->app->instance('path', 'src/Infrastructure');
    }

    private function registerAggregateRepositories()
    {
        $this->registerRepository(CommitteeRepository::class, Committee::class);
        $this->registerRepository(MemberRepository::class, Member::class);
        $this->registerRepository(PostRepository::class, Post::class);
        $this->registerRepository(RegistrationRequestRepository::class, RegistrationRequest::class);
    }

    private function registerReadModels()
    {
        $this->app->singleton(
            MemberListProjector::class,
            function (Application $app) {
                return new MemberListProjector(
                    $this->illuminateRepository('members', MemberList::class, 'uuid')
                );
            }
        );

        $this->app->singleton(
            CommitteesListProjector::class,
            function (Application $app) {
                return new CommitteesListProjector(
                    $this->illuminateRepository('committees_list', CommitteesList::class, 'id', ['members']),
                    $this->illuminateRepository('members', MemberList::class, 'uuid')
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
    private function registerRepository($repository, $aggregate)
    {
        $this->app->singleton(
            $repository,
            function () use ($repository, $aggregate) {
                return new $repository(
                    $this->makeEventSourcingRepository($aggregate)
                );
            }
        );
    }


    /**
     * Make a EventSourcingRepository for the given aggregate class
     *
     * Note we might want to replace this method with a factory class, the
     * advantage being that we can use that class in other service providers
     *
     * @param string $aggregate FQCN of the aggregate
     */
    private function makeEventSourcingRepository(string $aggregate) : EventSourcingRepository
    {
        return new EventSourcingRepository(
            $this->app->make(EventStoreInterface::class),
            $this->app->make(EventBusInterface::class),
            $aggregate,
            $this->app->make(AggregateFactoryInterface::class)
        );
    }
}
