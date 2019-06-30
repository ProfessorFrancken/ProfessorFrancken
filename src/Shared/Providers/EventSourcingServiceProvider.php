<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use Broadway\EventHandling\EventBus;
use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventSourcing\AggregateFactory\AggregateFactory;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventStore\EventStore;
use Broadway\Serializer\Serializer;
use Broadway\Serializer\SimpleInterfaceSerializer;
use BroadwaySerialization\Hydration\HydrateUsingReflection;
use BroadwaySerialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator;
use BroadwaySerialization\Reconstitution\Reconstitution;
use Doctrine\Instantiator\Instantiator;
use Francken\Infrastructure\EventSourcing\Factory;
use Francken\Infrastructure\EventSourcing\IlluminateEventStore;
use Francken\Infrastructure\EventSourcing\IlluminateEventStoreException;
use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;

class EventSourcingServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the event bus
     *
     * @return void
     */
    public function boot()
    {
        $eventBus = $this->app->make(EventBus::class);

        // The projections config contains a list of class names or projectors.
        // Each of these projectors will be subscribed to the given event bus.
        $projectors = $this->app->config->get('event_sourcing.projectors');

        foreach ($projectors as $projector) {
            $eventBus->subscribe(
                $this->app->make($projector)
            );
        }

        Reconstitution::reconstituteUsing(
            new ReconstituteUsingInstantiatorAndHydrator(
                new Instantiator(),
                new HydrateUsingReflection()
            )
        );
    }


    /**
     * Register event sourcing services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDefaultEventSourcingBindings();
        $this->registerEventStore();
    }

    /**
     * Registers default implementations for the aggregate factory,
     * serializer and the event bus.
     */
    private function registerDefaultEventSourcingBindings()
    {
        $this->app->bind(
            AggregateFactory::class,
            PublicConstructorAggregateFactory::class
        );

        $this->app->bind(
            Serializer::class,
            SimpleInterfaceSerializer::class
        );

        $this->app->singleton(
            EventBus::class,
            SimpleEventBus::class
        );
    }

    /**
     * Register bindings for the IlluminateEventStore and bind it as
     * the default EventS
     */
    private function registerEventStore()
    {
        $this->app->bind(IlluminateEventStore::class, function ($app) {
            $connection = $app->make(Connection::class);
            $serializer = $app->make(Serializer::class);
            $eventStoreTable = $app->config->get('event_sourcing.event_store_table');

            return new IlluminateEventStore(
                $connection,
                $serializer,
                $eventStoreTable
                // decorators (we could decorate the stream with account_id)
            );
        });

        $this->app->bind(
            EventStore::class,
            IlluminateEventStore::class
        );
    }
}
