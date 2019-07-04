<?php

declare(strict_types=1);

namespace Francken\Application;

use Broadway\Domain\DomainMessage;
use Broadway\ReadModel\Projector as BroadwayProjector;

abstract class Projector extends BroadwayProjector
{
    public function handle(DomainMessage $domainMessage): void
    {
        $event  = $domainMessage->getPayload();
        $method = $this->getHandleMethod($event);

        if (! method_exists($this, $method)) {
            return;
        }

        $this->$method($event, $domainMessage);
    }

    private function getHandleMethod($event)
    {
        $classParts = explode('\\', get_class($event));

        return 'when' . end($classParts);
    }
}
