<?php

declare(strict_types=1);

namespace Francken\Shared\Serialization\Hydration;

class HydrateUsingClosure implements Hydrate
{
    /** @var \Closure */
    private $hydrator;

    /**
     * @var[FQCN][property] = true means property exists
     */
    private $cache = [];

    /**
     * Creates a closure which is to be bound to an instance
     */
    public function __construct()
    {
        $this->hydrator = function (array $data, array $props) : void {
            foreach ($data as $key => $value) {
                if (isset($props[$key])) {
                    $this->{$key} = $value;
                }
            }
        };
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate(array $data, $object) : void
    {
        $class = get_class($object);
        if ( ! isset($this->cache[$class])) {
            $this->getProps($class);
        }

        $this->hydrator->call($object, $data, $this->cache[$class]);
    }

    /**
     * @param $class
     */
    private function getProps($class) : void
    {
        $this->cache[$class] = [];
        foreach ((new \ReflectionClass($class))->getProperties() as $property) {
            $this->cache[$class][$property->getName()] = true;
        }
    }
}
