<?php

declare(strict_types = 1);

namespace Francken\Shared\Serialization\Reconstitution;

use Doctrine\Instantiator\InstantiatorInterface;
use Francken\Shared\Serialization\Hydration\Hydrate;

/**
 * Uses doctrine/instantiator and a Hydrate instance to reconstitute objects
 */
final class ReconstituteUsingInstantiatorAndHydrator implements Reconstitute
{
    /**
     * @var InstantiatorInterface
     */
    private $instantiator;

    /**
     * @var Hydrate
     */
    private $hydrator;


    public function __construct(InstantiatorInterface $instantiator, Hydrate $hydrator)
    {
        $this->instantiator = $instantiator;
        $this->hydrator = $hydrator;
    }

    /**
     * @inheritdoc
     */
    public function objectFrom(string $className, array $data)
    {
        $object = $this->instantiator->instantiate($className);

        $this->hydrator->hydrate($data, $object);

        return $object;
    }
}
