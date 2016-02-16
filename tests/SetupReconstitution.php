<?php

namespace Tests;

use BroadwaySerialization\Reconstitution\Reconstitution;
use BroadwaySerialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator;
use Doctrine\Instantiator\Instantiator;
use BroadwaySerialization\Hydration\HydrateUsingReflection;

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