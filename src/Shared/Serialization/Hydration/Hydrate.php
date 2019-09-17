<?php

declare(strict_types = 1);

namespace Francken\Shared\Serialization\Hydration;

/**
 * Used by {@see \BroadwaySerialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator} to copy data into a
 * previously instantiated object.
 */
interface Hydrate
{
    /**
     * Copy the provided data into the properties of the provided object
     *
     * @param object $object
     */
    public function hydrate(array $data, $object);
}
