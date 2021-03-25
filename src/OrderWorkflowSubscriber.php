<?php

namespace App;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class OrderWorkflowSubscriber implements EventSubscriberInterface
{
    public function onLeave(Event $event)
    {
        echo (sprintf(
            'Order (id: %s) performed transition "%s" from "%s" to "%s"',
            $event->getSubject()->getId(),
            $event->getTransition()->getName(),
            implode(', ', array_keys($event->getMarking()->getPlaces())),
            implode(', ', $event->getTransition()->getTos())
        ));

        echo "<br>";
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.unnamed.leave' => 'onLeave'
        ];
    }
}