<?php

declare(strict_types=1);

namespace Francken\Features\Repositories;

use Broadway\ReadModel\Identifiable as ReadModelInterface;
use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Shared\Serializable;

final class TestReadModel implements ReadModelInterface, SerializableInterface
{
    use Serializable;

    private $id;
    private $first;
    private $second;

    public static function create(string $id, string $first, string $second) : self
    {
        $instance = new self();
        $instance->id = $id;
        $instance->first = $first;
        $instance->second = $second;
        return $instance;
    }

    public function getId() : string
    {
        return $this->id;
    }
}
