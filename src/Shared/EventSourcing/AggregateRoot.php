<?php

declare(strict_types=1);

namespace Francken\Shared\EventSourcing;

use Broadway\EventSourcing\EventSourcedAggregateRoot;

/**
 * This class is intentionally left blank.
 * Our event sourced aggregates should be extending this class
 * so that in the event that we stop depending on Broadway we only
 * have to change this abstract class.
 */
abstract class AggregateRoot extends EventSourcedAggregateRoot
{
}
