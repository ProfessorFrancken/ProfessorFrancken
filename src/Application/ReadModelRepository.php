<?php

declare(strict_types=1);

namespace Francken\Application;

use Broadway\ReadModel\ReadModelInterface;
use Broadway\Serializer\SerializableInterface;

interface ReadModelRepository
{
    /**
     * @param ReadModelInterface $model
     */
    public function save(ReadModelInterface $model);

    /**
     * @param string $id
     *
     * @return ReadModelInterface
     * @throws ReadModelNotFound
     */
    public function find(string $id) : ReadModelInterface;

    /**
     * @param array $fields
     *
     * @return ReadModelInterface[]
     */
    public function findBy(array $fields) : array;

    /**
     * @return ReadModelInterface[]
     */
    public function findAll() : array;

    /**
     * @param array $ids
     * @return ReadModelInterface[]
     */
    public function findByIds(array $ids) : array;

    /**
     * @param string $id
     */
    public function remove(string $id);

    /**
     * @param array $fields
     */
    public function removeBy(array $fields);
}
