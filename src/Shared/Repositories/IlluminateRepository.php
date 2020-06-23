<?php

declare(strict_types=1);

namespace Francken\Shared\Repositories;

use Broadway\ReadModel\Identifiable as ReadModelInterface;
use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Shared\ReadModelNotFound;
use Francken\Shared\ReadModelRepository;
use Illuminate\Database\ConnectionInterface as Connection;
use Illuminate\Support\Collection;

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

    
    public function save(ReadModelInterface $model) : void
    {
        $this->connection->table($this->table)->updateOrInsert([
            $this->primaryKey => (string)$model->getId()
        ], $this->serialize($model));
    }

    /**
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
     * @return ReadModelInterface[]
     */
    public function findByIds(array $ids) : array
    {
        $rows = $this->connection->table($this->table)->whereIn($this->primaryKey, $ids)->get();

        return $this->deserializeRows($rows);
    }

    
    public function remove(string $id) : void
    {
        $this->connection->table($this->table)->where($this->primaryKey, $id)->delete();
    }

    
    public function removeBy(array $fields) : void
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
     */
    private function serialize(SerializableInterface $model) : array
    {
        $array = $model->serialize();

        foreach ($this->stringify as $column) {
            $array[$column] = json_encode($array[$column]);
        }

        return $array;
    }

    /**
     * Since SQL databases are normalized, nested structures
     * muse be deserialized from JSON to arrays.
     */
    private function deserialize(\stdClass $object) : ReadModelInterface
    {
        $array = (array)$object;

        foreach ($this->stringify as $column) {
            $array[$column] = json_decode($array[$column], true);
        }

        return ($this->model)::deserialize($array);
    }

    
    private function deserializeRows(Collection $rows) : array
    {
        return $rows->map(function ($row) {
            return $this->deserialize($row);
        })->all();
    }
}
