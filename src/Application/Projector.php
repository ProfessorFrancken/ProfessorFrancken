<?php

namespace Francken\Application;

use Broadway\ReadModel\Projector as BroadwayProjector;
use Broadway\Domain\DomainMessage;

abstract class Projector extends BroadwayProjector
{
    public function handle(DomainMessage $domainMessage)
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
