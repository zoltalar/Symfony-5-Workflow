<?php

namespace App;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow;

class OrderWorkflow
{
    const STATE_OPEN = 'open';
    const STATE_CONFIRMED = 'confirmed';
    const STATE_ASSIGNED_TO_PICKER = 'assigned-to-picker';
    const STATE_DELIVERED = 'delivered';
    const STATE_CANCELLED = 'cancelled';

    const TRANSITION_UPDATE_ITEM = 'updateItem';
    const TRANSITION_ASSIGN_CUSTOMER = 'assignCustomer';
    const TRANSITION_CONFIRM_ORDER = 'confirmOrder';
    const TRANSITION_ASSIGN_PICKER = 'assignPicker';
    const TRANSITION_CONFIRM_DELIVERY = 'confirmDelivery';
    const TRANSITION_CANCEL_ORDER = 'cancelOrder';

    public static function getWorkflow($dispatcher): Workflow
    {
        $definitionBuilder = new DefinitionBuilder();

        $definition = $definitionBuilder
            ->addPlaces([
                self::STATE_OPEN,
                self::STATE_CONFIRMED,
                self::STATE_ASSIGNED_TO_PICKER,
                self::STATE_DELIVERED,
                self::STATE_CANCELLED
            ])
            ->addTransition(new Transition(self::TRANSITION_UPDATE_ITEM, self::STATE_OPEN, self::STATE_OPEN))
            ->addTransition(new Transition(self::TRANSITION_ASSIGN_CUSTOMER, self::STATE_OPEN, self::STATE_OPEN))
            ->addTransition(new Transition(self::TRANSITION_CONFIRM_ORDER, self::STATE_OPEN, self::STATE_CONFIRMED))
            ->addTransition(new Transition(self::TRANSITION_ASSIGN_PICKER, self::STATE_CONFIRMED, self::STATE_ASSIGNED_TO_PICKER))
            ->addTransition(new Transition(self::TRANSITION_CONFIRM_DELIVERY, self::STATE_ASSIGNED_TO_PICKER, self::STATE_DELIVERED))
            ->addTransition(new Transition(self::TRANSITION_CANCEL_ORDER, [self::STATE_OPEN, self::STATE_CONFIRMED, self::STATE_ASSIGNED_TO_PICKER], self::STATE_CANCELLED))
            ->build();

        $marking = new MethodMarkingStore(true, 'state');

        return new Workflow($definition, $marking, $dispatcher);
    }
}