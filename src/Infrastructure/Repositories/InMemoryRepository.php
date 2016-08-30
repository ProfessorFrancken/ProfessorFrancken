<?php

declare(strict_types = 1);

namespace Francken\Infrastructure\Repositories;

use Broadway\ReadModel\ReadModelInterface;
use Francken\Application\ReadModelNotFound;
use Francken\Application\ReadModelRepository;
use ReflectionClass;
use stdClass;

final class InMemoryRepository implements ReadModelRepository
{
    private $data = [];

    /**
     * @var null
     */
    private $model;

    /** @var \ReflectionProperty[] */
    private $properties = [];

    public function __construct($model = stdClass::class)
    {
        $this->model = $model;

        foreach ((new ReflectionClass($model))->getProperties() as $property) {
            $this->properties[$property->getName()] = $property;
            $property->setAccessible(true);
        }
    }

    /**
     * @param ReadModelInterface $model
     */
    public function save(ReadModelInterface $model)
    {
        $this->data[(string)$model->getId()] = $model;
    }

    /**
     * @param string $id
     *
     * @return ReadModelInterface
     * @throws ReadModelNotFound
     */
    public function find(string $id) : ReadModelInterface
    {
        if (isset($this->data[$id])) {
            return $this->data[$id];
        }

        throw ReadModelNotFound::with($id);
    }

    /**
     * @param array $fields
     *
     * @return ReadModelInterface[]
     */
    public function findBy(array $fields) : array
    {
        if (! $this->fieldsAreValid($fields)) {
            return [];
        }

        return array_values(
            array_filter(
                $this->data,
                function ($model) use ($fields) {
                    foreach ($fields as $field => $value) {
                        if ($this->properties[$field]->getValue($model) != $value) {
                            return false;
                        }
                    }

                    return true;
                }
            )
        );
    }

    /**
     * @return ReadModelInterface[]
     */
    public function findAll() : array
    {
        return array_values($this->data);
    }

    /**
     * @param array $ids
     * @return ReadModelInterface[]
     */
    public function findByIds(array $ids) : array
    {
        return array_values(array_intersect_key($this->data, array_flip($ids)));
    }

    /**
     * @param string $id
     */
    public function remove(string $id)
    {
        unset($this->data[(string)$id]);
    }

    /**
     * @param array $fields
     */
    public function removeBy(array $fields)
    {
        $remove = [];
        foreach ($this->findBy($fields) as $model) {
            $remove[$model->getId()] = $model;
        }

        $this->data = array_diff_key($this->data, $remove);
    }

    /**
     * Check that the fields (used for searching) are valid
     * If the fields are empty, or if they contain at least one key that
     * is not present as a property of our model then the field is not valid
     */
    private function fieldsAreValid(array $fields) : bool
    {
        if (empty($fields)) {
            return false;
        }

        // Check that all fields are included in the properties of our model
        if (array_keys(array_intersect_key($fields, $this->properties)) !== array_keys($fields)) {
            return false;
        }

        return true;
    }
}
