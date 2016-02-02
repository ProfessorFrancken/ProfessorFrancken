<?php

namespace App\EventSourcing;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;

use Broadway\EventStore\EventStoreInterface;
use Broadway\Serializer\SerializerInterface;
use Broadway\Serializer\SimpleInterfaceSerializer;
use Broadway\EventHandling\EventBusInterface;
use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventSourcing\AggregateFactory\AggregateFactoryInterface;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;

class EventSourcingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            AggregateFactoryInterface::class,
            PublicConstructorAggregateFactory::class
        );

        $this->app->bind(
            SerializerInterface::class,
            SimpleInterfaceSerializer::class
        );

        $this->app->bind(
            EventBusInterface::class,
            SimpleEventBus::class
        );

        $this->registerEventStore();
    }

    private function registerEventStore()
    {
        $this->app->bind(IlluminateEventStore::class, function ($app) {
            $connection = $app->make(Connection::class);
            $serializer = $app->make(SerializerInterface::class);
            $eventStoreTable = 'event_store';

            return new IlluminateEventStore(
                $connection,
                $serializer,
                $eventStoreTable
            );
        });

        $this->app->bind(
            EventStoreInterface::class,
            IlluminateEventStore::class
        );
    }
}
