<?php

declare(strict_types = 1);

namespace Francken\Shared\Serialization\Reconstitution;

interface Reconstitute
{
    /**
     * Reconstitute an object by creating an instance of the given class name, then copying the provided data into its
     * properties.
     *
     * @return object of type $className
     */
    public function objectFrom(string $className, array $data);
}
