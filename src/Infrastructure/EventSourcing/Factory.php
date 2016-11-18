<?php

declare(strict_types=1);

namespace Francken\Infrastructure\EventSourcing;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\AggregateFactoryInterface;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;

final class Factory
{
    private $store;
    private $bus;
    private $factory;

    public function __construct(
        EventStoreInterface $eventStore,
        EventBusInterface $bus,
        AggregateFactoryInterface $factory
    ) {
        $this->store = $eventStore;
        $this->bus = $bus;
        $this->factory = $factory;
    }

    /**
     * Creates a new binding for an event sourced aggregate repository
     * @param string $repository classname
     * @param string $aggregate classname
     */
    public function buildForAggregate(string $aggregate) : EventSourcingRepository
    {
        return new EventSourcingRepository(
            $this->store,
            $this->bus,
            $aggregate,
            $this->factory
        );
    }
}
