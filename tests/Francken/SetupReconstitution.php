<?php

declare(strict_types=1);

namespace Francken\Tests;

use Doctrine\Instantiator\Instantiator;
use Francken\Shared\Serialization\Hydration\HydrateUsingReflection;
use Francken\Shared\Serialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator;
use Francken\Shared\Serialization\Reconstitution\Reconstitution;

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
