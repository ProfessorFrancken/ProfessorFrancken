<?php

declare(strict_types=1);

namespace Francken\Shared;

abstract class EventHandler
{
    public function handle(object $event) : void
    {
        $method = $this->getHandleMethod($event);

        if ( ! method_exists($this, $method)) {
            return;
        }

        $this->$method($event);
    }

    private function getHandleMethod(object $event) : string
    {
        $classParts = explode('\\', get_class($event));

        return 'when' . end($classParts);
    }
}
