<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

require 'src/Customer.php';
require 'src/Order.php';
require 'src/OrderWorkflow.php';
require 'src/OrderWorkflowSubscriber.php';
require 'src/Picker.php';
require 'src/Product.php';

use App\Customer;
use App\Order;
use App\OrderWorkflow;
use App\OrderWorkflowSubscriber;
use App\Picker;
use App\Product;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Workflow\Workflow;

$order = new Order(1);

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber($subscriber = new OrderWorkflowSubscriber());

$orderWorkflow = OrderWorkflow::getWorkflow($dispatcher);

// Apply a transition
transition($orderWorkflow, $order, OrderWorkflow::TRANSITION_UPDATE_ITEM);
canTransitionToDelivered($orderWorkflow, $order);

transition($orderWorkflow, $order, OrderWorkflow::TRANSITION_CONFIRM_ORDER);
transition($orderWorkflow, $order, OrderWorkflow::TRANSITION_ASSIGN_PICKER);

canTransitionToDelivered($orderWorkflow, $order);

function transition(Workflow $orderWorkflow, Order $order, string $transition)
{
    if ( ! $orderWorkflow->can($order, $transition)) {
        return false;
    }

    $orderWorkflow->apply($order, $transition);

    return true;
}

function canTransitionToDelivered(Workflow $orderWorkflow, Order $order)
{
    return $orderWorkflow->can($order, OrderWorkflow::TRANSITION_CONFIRM_DELIVERY);
}