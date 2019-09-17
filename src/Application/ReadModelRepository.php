<?php

declare(strict_types=1);

namespace Francken\Application;

use Broadway\ReadModel\Identifiable as ReadModelInterface;

interface ReadModelRepository
{
    public function save(ReadModelInterface $model);

    /**
     * @throws ReadModelNotFound
     */
    public function find(string $id) : ReadModelInterface;

    /**
     * @return ReadModelInterface[]
     */
    public function findBy(array $fields) : array;

    /**
     * @return ReadModelInterface[]
     */
    public function findAll() : array;

    /**
     * @return ReadModelInterface[]
     */
    public function findByIds(array $ids) : array;

    
    public function remove(string $id);

    
    public function removeBy(array $fields);
}
