<?php

declare(strict_types=1);

namespace Francken\Features;

use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use Broadway\EventStore\EventStore;
use Broadway\EventStore\EventStreamNotFoundException;
use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Infrastructure\EventSourcing\IlluminateEventStoreException;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EventStoreFeature extends TestCase
{
    use DatabaseMigrations;

    private $store;

    public function setUp() : void
    {
        parent::setUp();

        $this->store = $this->app->make(EventStore::class);
    }

    /**
     * @test
     */
    public function an_event_stream_can_be_saved_to_the_database() : void
    {
        $eventStream = new DomainEventStream([
            DomainMessage::recordNow(
                'aggregate-1',
                0,
                new Metadata([]),
                new ADomainEvent()
            )
        ]);
        $this->store->append('aggregate-1', $eventStream);
        $loaded = $this->store->load('aggregate-1');
        $this->assertEquals($eventStream, $loaded);
    }

    /**
     * @test
     */
    public function an_event_stream_of_more_than_one_event_can_be_saved() : void
    {
        $eventStream = new DomainEventStream([
            DomainMessage::recordNow(
                'aggregate-1',
                0,
                new Metadata(array()),
                new ADomainEvent
            ),
            DomainMessage::recordNow(
                'aggregate-1',
                1,
                new Metadata(array()),
                new ADomainEvent
            )
        ]);
        $this->store->append('aggregate-1', $eventStream);
        $loaded = $this->store->load('aggregate-1');
        $this->assertEquals($eventStream, $loaded);
    }

    /**
     * @test
     */
    public function the_event_stream_of_more_than_one_aggregate_can_be_saved()
    {
        $eventStream = new DomainEventStream([
            DomainMessage::recordNow(
                'aggregate-1',
                0,
                new Metadata(array()),
                new ADomainEvent
            ),
            DomainMessage::recordNow(
                'aggregate-1',
                1,
                new Metadata(array()),
                new ADomainEvent
            )
        ]);
        $this->store->append('aggregate-1', $eventStream);


        $secondStream = new DomainEventStream([
            DomainMessage::recordNow(
                'aggregate-2',
                0,
                new Metadata(array()),
                new ADomainEvent
            )
        ]);
        $this->store->append('aggregate-2', $secondStream);
        $this->assertEquals($eventStream, $this->store->load('aggregate-1'));
        $this->assertEquals($secondStream, $this->store->load('aggregate-2'));
    }

    /**
     * @test
     */
    public function it_cant_find_a_event_stream_of_a_non_existing_aggregate()
    {
        $this->expectException(EventStreamNotFoundException::class);
        $this->store->load('aggregate-1');
    }

    /**
     * @test
     */
    public function when_appending_one_event_from_a_event_stream_fails_it_rolls_back_all_changes()
    {
        $this->expectException(IlluminateEventStoreException::class);

        $eventStream = new DomainEventStream([
            DomainMessage::recordNow(
                'aggregate-1',
                0,
                new Metadata(array()),
                new ADomainEvent
            ),
            DomainMessage::recordNow(
                'aggregate-1',
                1,
                new Metadata(array()),
                new AThrowingDomainEent
            ),
        ]);

        $this->store->append('aggregate-1', $eventStream);
    }
}

final class ADomainEvent implements SerializableInterface
{

    public static function deserialize(array $data)
    {
        return new static($data['my_event']);
    }

    public function serialize(): array
    {
        return [
            'my_event' => 'l33t'
        ];
    }
}

final class AThrowingDomainEent implements SerializableInterface
{

    public static function deserialize(array $data)
    {
        return new static($data['my_event']);
    }

    public function serialize(): array
    {
        throw new  \Exception('This is an invalid event');
    }
}
