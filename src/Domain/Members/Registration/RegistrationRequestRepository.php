<?php

namespace Francken\Domain\Members\Registration;


use Broadway\EventHandling\EventBusInterface;
use Broadway\EventStore\EventStoreInterface;
use Broadway\EventSourcing\AggregateFactory\AggregateFactoryInterface;
use Broadway\EventSourcing\EventSourcingRepository;

class RegistrationRequestRepository extends EventSourcingRepository
{
    public function __construct(
        EventStoreInterface $eventStore,
        EventBusInterface $eventBus,
        AggregateFactoryInterface $factory,
        array $eventStreamDecorators = array()
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            RegistrationRequest::class,
            $factory,
            $eventStreamDecorators
        );
    }
}
