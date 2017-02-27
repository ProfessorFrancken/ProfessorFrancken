<?php

declare(strict_types=1);

namespace Francken\Tests;

use BroadwaySerialization\Hydration\HydrateUsingReflection;
use BroadwaySerialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator;
use BroadwaySerialization\Reconstitution\Reconstitution;
use Doctrine\Instantiator\Instantiator;

trait SetupReconstitution
{
    /**
     * @before
     */
    public function setupSomeFixtures()
    {
        Reconstitution::reconstituteUsing(
            new ReconstituteUsingInstantiatorAndHydrator(
                new Instantiator(),
                new HydrateUsingReflection()
            )
        );
    }
}
