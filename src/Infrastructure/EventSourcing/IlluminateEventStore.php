<?php

declare(strict_types=1);

namespace Francken\Infrastructure\EventSourcing;

use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\DateTime;
use Broadway\EventStore\EventStore;
use Broadway\EventStore\EventStreamNotFoundException;
use Broadway\Serializer\Serializer;
use Illuminate\Database\ConnectionInterface as Connection;

final class IlluminateEventStore implements EventStore
{

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var \Broadway\Serializer\Serializer
     */
    private $serializer;

    /**
     * @var string, the table name of the event store
     */
    private $table;

    /**
     * Construct the dependancies
     *
     * @param \Illuminate\Database\DatabaseManager $databaseManager
     * @param Serializer $serializer
     * @param string $eventStoreTable
     */
    public function __construct(
        Connection $connection,
        Serializer $serializer,
        string $eventStoreTable
    ) {
        $this->connection = $connection;
        $this->serializer = $serializer;
        $this->table = $eventStoreTable;
    }

    /**
     * {@inheritdoc}
     */
    public function load($id)
    {
        $events = $this->loadEvents($id);

        if (! $events) {
            throw new EventStreamNotFoundException(sprintf('EventStream not found for aggregate with id %s', $id));
        }

        return new DomainEventStream(
            array_map(function ($event) {
                return $this->deserializeEvent($event);
            }, $events)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function loadFromPlayhead($id, $playhead)
    {
        $events = $this->loadEvents($id, $playhead);

        if (! $events) {
            throw new EventStreamNotFoundException(sprintf('EventStream not found for aggregate with id %s', $id));
        }

        return new DomainEventStream(
            array_map(function ($event) {
                return $this->deserializeEvent($event);
            }, $events)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function append($id, DomainEventStream $eventStream)
    {
        $this->connection->beginTransaction();

        try {
            foreach ($eventStream as $event) {
                $this->appendEvent($event);
            }

            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollBack();
            IlluminateEventStoreException::failedToAppend($e);
        }
    }

    /**
     * Load all events of an aggregate from our table
     * Note that since Laravel 5.3 the connection will now return a collection object
     */
    private function loadEvents(string $id, int $playhead = 0) : array
    {
        return $this->connection->table($this->table)
            ->where('uuid', $id)
            ->where('playhead', '>=', $playhead)
            ->get()
            ->all();
    }

    /**
     * Deserialize a result row to a DomainMessage
     *
     * @author Dennis Schepers
     *
     * @param $row
     *
     * @return \Broadway\Domain\DomainMessage
     */
    private function deserializeEvent($event)
    {
        return new DomainMessage(
            $event->uuid,
            (int) $event->playhead,
            $this->deserialize($event->metadata),
            $this->deserialize($event->payload),
            DateTime::fromString($event->recorded_on)
        );
    }

    /**
     * Appends an event to the event store
     */
    private function appendEvent(DomainMessage $event)
    {
        $this->connection->table($this->table)->insert([
            'uuid'        => (string) $event->getId(),
            'playhead'    => (int) $event->getPlayhead(),
            'metadata'    => $this->serialize($event->getMetadata()),
            'payload'     => $this->serialize($event->getPayload()),
            'recorded_on' => $event->getRecordedOn()->toString(),
            'type'        => $event->getType(),
        ]);
    }

    /**
     * Deserialize json after it's been converted to associated arrays
     */
    private function deserialize($json)
    {
        return $this->serializer->deserialize(
            json_decode($json, true)
        );
    }

    /**
     * serialize some property to json
     */
    private function serialize($property)
    {
        return json_encode(
            $this->serializer->serialize($property)
        );
    }
}
