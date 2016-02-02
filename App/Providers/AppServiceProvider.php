<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;
use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\AggregateFactoryInterface;

use Francken\Committees\Committee;
use Francken\Committees\CommitteeRepository;

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
    }

    /**
     * Creates a new binding for an event sourced aggregate repository
     * @param string $repository classname
     * @param string $aggregae classname
     */
    private function registerRepository($repository, $aggregate)
    {
        $this->app->bind(
            $repository,
            function ($app) use ($aggregate) {
                // Perhaps at this point we should subscribe all our projectors to the event bus
                $eventStore = $app->make(EventStoreInterface::class);
                $eventBus = $app->make(EventBusInterface::class);
                $factory = $app->make(AggregateFactoryInterface::class);

                return new EventSourcingRepository(
                    $eventStore,
                    $eventBus,
                    $aggregate,
                    $factory
                );
            }
        );
    }
}
