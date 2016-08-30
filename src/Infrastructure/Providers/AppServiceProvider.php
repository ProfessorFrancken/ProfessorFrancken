<?php

namespace Francken\Infrastructure\Providers;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\AggregateFactoryInterface;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;
use Francken\Domain\Committees\Committee;
use Francken\Domain\Committees\CommitteeRepository;
use Francken\Domain\Members\Member;
use Francken\Domain\Members\MemberRepository;
use Francken\Domain\Members\Registration\RegistrationRequest;
use Francken\Domain\Members\Registration\RegistrationRequestRepository;
use Francken\Domain\Posts\Post;
use Francken\Domain\Posts\PostRepository;
use Illuminate\Contracts\Foundation\Application;
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
        $this->registerRepository(CommitteeRepository::class, Committee::class);
        $this->registerRepository(MemberRepository::class, Member::class);
        $this->registerRepository(PostRepository::class, Post::class);
        $this->registerRepository(RegistrationRequestRepository::class, RegistrationRequest::class);
        $this->app->instance('path', 'src/Infrastructure');
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
            function (Application $app) use ($repository, $aggregate) {
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
