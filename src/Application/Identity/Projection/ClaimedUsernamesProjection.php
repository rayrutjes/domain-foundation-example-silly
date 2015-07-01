<?php 

namespace RayRutjes\DomainFoundation\Example\Application\Identity\Projection;

use RayRutjes\DomainFoundation\Domain\Event\Event;
use RayRutjes\DomainFoundation\EventBus\Listener\EventListener;

class ClaimedUsernamesProjection implements EventListener
{
    /**
     * @param Event $event
     *
     * @return mixed
     */
    public function handle(Event $event)
    {
        // TODO: Implement handle() method.
    }
}
