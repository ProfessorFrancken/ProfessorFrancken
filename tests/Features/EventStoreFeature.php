<?php

declare(strict_types=1);

namespace Francken\Features;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Broadway\Serializer\SerializableInterface;
use Broadway\EventStore\EventStoreInterface;
use Broadway\EventStore\EventStreamNotFoundException;
use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use Francken\Infrastructure\EventSourcing\EventSourcingServiceProvider;
use Francken\Infrastructure\EventSourcing\IlluminateEventStoreException;

class EventStoreFeature extends TestCase
{
    use DatabaseMigrations;

    private $store;

    public function setUp()
    {
        parent::setUp();

        $this->store = $this->app->make(EventStoreInterface::class);
    }

    /**
     * @test
     */
    public function an_event_stream_can_be_saved_to_the_database()
    {
        $eventStream = new DomainEventStream([
            DomainMessage::recordNow(
                'aggregate-1',
                0,
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
    public function an_event_stream_of_more_than_one_event_can_be_saved()
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
        // this test is a bit of an hack, by mocking the DateTime object we make
        // the append() method of the event store throw an exception
        $time = $this->prophesize(\Broadway\Domain\DateTime::class);
        $time->toString()
            ->willThrow(new \Exception('This is an invalid event'));

        $eventStream = new DomainEventStream([
            DomainMessage::recordNow(
                'aggregate-1',
                0,
                new Metadata(array()),
                new ADomainEvent
            ),
            new DomainMessage(
                'aggregate-1',
                1,
                new Metadata(array()),
                new ADomainEvent,
                $time->reveal()
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

    public function serialize()
    {
        return [
            'my_event' => 'l33t'
        ];
    }
}
