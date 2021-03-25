<?php

require 'vendor/autoload.php';
require 'src/Order.php';
require 'src/OrderWorkflow.php';

use App\Order;
use App\OrderWorkflow;
use Symfony\Component\Workflow\Workflow;

$order = new Order();
$orderWorkflow = OrderWorkflow::getWorkflow();

// Apply a transition
transition($orderWorkflow, $order, OrderWorkflow::TRANSITION_UPDATE_ITEM);
canTransitionToDelivered($orderWorkflow, $order);

transition($orderWorkflow, $order, OrderWorkflow::TRANSITION_CONFIRM_ORDER);
transition($orderWorkflow, $order, OrderWorkflow::TRANSITION_ASSIGN_PICKER);

canTransitionToDelivered($orderWorkflow, $order);

function transition(Workflow $orderWorkflow, Order $order, string $transition)
{
    $orderWorkflow->apply($order, $transition);
    echo ('Transitioned to: ' . $order->getState() . '<br>');
}

function canTransitionToDelivered(Workflow $orderWorkflow, Order $order)
{
    $canTransitionToDelivered = $orderWorkflow->can($order, OrderWorkflow::TRANSITION_CONFIRM_DELIVERY);
    echo ('Can transition to delivery: '); var_dump($canTransitionToDelivered); echo '<br>';

    return $canTransitionToDelivered;
}