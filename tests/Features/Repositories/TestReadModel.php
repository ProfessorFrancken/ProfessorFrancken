<?php

declare(strict_types=1);

namespace Francken\Features\Repositories;

use Broadway\ReadModel\Identifiable as ReadModelInterface;
use Broadway\Serializer\Serializable as SerializableInterface;
use BroadwaySerialization\Serialization\AutoSerializable as Serializable;

final class TestReadModel implements ReadModelInterface, SerializableInterface
{
    use Serializable;

    private $id;
    private $first;
    private $second;

    public static function create(string $id, string $first, string $second) : TestReadModel
    {
        $instance = new self;
        $instance->id = $id;
        $instance->first = $first;
        $instance->second = $second;
        return $instance;
    }

    public function getId()
    {
        return $this->id;
    }
}
