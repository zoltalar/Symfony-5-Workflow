<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

require 'src/Customer.php';
require 'src/Order.php';
require 'src/OrderWorkflow.php';
require 'src/OrderWorkflowSubscriber.php';
require 'src/OrderService.php';
require 'src/Picker.php';
require 'src/Product.php';

use App\Customer;
use App\Order;
use App\OrderWorkflow;
use App\OrderWorkflowSubscriber;
use App\OrderService;
use App\Picker;
use App\Product;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Workflow\Workflow;

$order = new Order(1);

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new OrderWorkflowSubscriber());

$orderWorkflow = OrderWorkflow::getWorkflow($dispatcher);
$orderService = new OrderService($orderWorkflow, $order);

$items = [
    new Product('Banana', 2),
    new Product('Apple', 1.5),
    new Product('Blueberries', 1.0)
];

$orderService->updateItems($items);
$orderService->updateCustomer(new Customer('John Smith'));
$orderService->confirmOrder();
$orderService->updatePicker(new Picker('Jane McTest'));