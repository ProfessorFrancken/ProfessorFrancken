<?php

declare(strict_types=1);

namespace Francken\Shared\EventSourcing;

use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\AggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;

final class Factory
{
    private $store;
    private $bus;
    private $factory;

    public function __construct(
        EventStore $eventStore,
        EventBus $bus,
        AggregateFactory $factory
    ) {
        $this->store = $eventStore;
        $this->bus = $bus;
        $this->factory = $factory;
    }

    /**
     * Creates a new binding for an event sourced aggregate repository
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
