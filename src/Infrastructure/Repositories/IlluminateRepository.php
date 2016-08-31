<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Repositories;

use Broadway\ReadModel\ReadModelInterface;
use Broadway\Serializer\SerializableInterface;
use Francken\Application\ReadModelNotFound;
use Francken\Application\ReadModelRepository;
use Illuminate\Database\ConnectionInterface as Connection;

final class IlluminateRepository implements ReadModelRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $table;

    /**
     * @var string|SerializableInterface|ReadModelInterface
     */
    private $model;

    /**
     * @var string
     */
    private $primaryKey;

    /**
     * @var array
     */
    private $stringify;

    /**
     * IlluminateRepository constructor.
     * @param Connection $connection
     * @param string $table
     * @param string $model
     * @param string $primaryKey
     * @param array $stringify Specify the columns which must be stringified
     */
    public function __construct(
        Connection $connection,
        string $table,
        string $model,
        string $primaryKey = 'id',
        array $stringify = []
    ) {
        $this->connection = $connection;
        $this->table = $table;
        $this->model = $model;
        $this->primaryKey = $primaryKey;
        $this->stringify = $stringify;
    }

    /**
     * @param ReadModelInterface $model
     */
    public function save(ReadModelInterface $model)
    {
        $this->connection->table($this->table)->updateOrInsert([
            $this->primaryKey => (string)$model->getId()
        ], $this->serialize($model));
    }

    /**
     * @param string $id
     *
     * @return ReadModelInterface
     * @throws ReadModelNotFound
     */
    public function find(string $id) : ReadModelInterface
    {
        /** @var \stdClass|null $row */
        $row = $this->connection->table($this->table)->where($this->primaryKey, $id)->first();

        if (is_null($row)) {
            throw ReadModelNotFound::with($id);
        }

        return $this->deserialize($row);

    }

    /**
     * @param array $fields
     *
     * @return ReadModelInterface[]
     */
    public function findBy(array $fields) : array
    {
        if (empty($fields)) {
            return [];
        }

        $rows = $this->connection->table($this->table)->where($fields)->get();

        return $this->deserializeRows($rows);
    }

    /**
     * @return ReadModelInterface[]
     */
    public function findAll() : array
    {
        $rows = $this->connection->table($this->table)->get();

        return $this->deserializeRows($rows);
    }

    /**
     * @param array $ids
     * @return ReadModelInterface[]
     */
    public function findByIds(array $ids) : array
    {
        $rows = $this->connection->table($this->table)->whereIn($this->primaryKey, $ids)->get();

        return $this->deserializeRows($rows);
    }

    /**
     * @param string $id
     */
    public function remove(string $id)
    {
        $this->connection->table($this->table)->where($this->primaryKey, $id)->delete();
    }

    /**
     * @param array $fields
     */
    public function removeBy(array $fields)
    {
        if (empty($fields)) {
            return;
        }

        $this->connection->table($this->table)->where($fields)->delete();
    }

    // We migth want to replace these methods with a generic serializer

    /**
     * Since SQL databases are normalized, nested arrays
     * must be serialized to JSON.
     * @param SerializableInterface $model
     * @return array
     */
    private function serialize(SerializableInterface $model) : array
    {
        return $model->serialize();
    }

    /**
     * Since SQL databases are normalized, nested structures
     * muse be deserialized from JSON to arrays.
     * @param \stdClass $object
     * @return ReadModelInterface
     */
    private function deserialize(\stdClass $object) : ReadModelInterface
    {
        return ($this->model)::deserialize((array)$object);
    }


    /**
     * @param array $rows
     * @return array
     */
    private function deserializeRows(array $rows) : array
    {
        return array_map(
            function ($row) {
                return $this->deserialize($row);
            },
            $rows
        );
    }
}
