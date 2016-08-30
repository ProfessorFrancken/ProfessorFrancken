<?php

declare(strict_types=1);

namespace Francken\Infrastructure\EventSourcing;

use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainEventStreamInterface;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\DateTime;
use Broadway\EventStore\EventStoreInterface;
use Broadway\EventStore\EventStreamNotFoundException;
use Broadway\Serializer\SerializerInterface;
use Illuminate\Database\ConnectionInterface as Connection;

final class IlluminateEventStore implements EventStoreInterface
{

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var \Broadway\Serializer\SerializerInterface
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
     * @param SerializerInterface $serializer
     * @param string $eventStoreTable
     */
    public function __construct(
        Connection $connection,
        SerializerInterface $serializer,
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
        $events = $this->connection
                ->table($this->table)
                ->where('uuid', $id)
                ->get();

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
    public function append($id, DomainEventStreamInterface $eventStream)
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
