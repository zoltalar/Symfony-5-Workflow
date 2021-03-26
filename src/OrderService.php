<?php

namespace App;

use Symfony\Component\Workflow\Workflow;

class OrderService
{
    protected $orderWorkflow;
    protected $order;

    public function __construct(Workflow $orderWorkflow, Order $order)
    {
        $this->orderWorkflow = $orderWorkflow;
        $this->order = $order;
    }

    public function updatePicker(Picker $picker)
    {
        $changeOrder = $this->order;
        $changeOrder->setPicker($picker);

        $this->transition($changeOrder, OrderWorkflow::TRANSITION_ASSIGN_PICKER);
    }

    public function updateCustomer(Customer $customer)
    {
        $changeOrder = $this->order;
        $changeOrder->setCustomer($customer);

        $this->transition($changeOrder, OrderWorkflow::TRANSITION_ASSIGN_CUSTOMER);
    }

    public function confirmOrder()
    {
        $this->transition($this->order, OrderWorkflow::TRANSITION_ASSIGN_CUSTOMER);
    }

    public function updateItems(array $items)
    {
        $changeOrder = $this->order;
        $changeOrder->setItems($items);

        $this->transition($changeOrder, OrderWorkflow::TRANSITION_UPDATE_ITEM);
    }

    public function transition(Order $order, string $transition)
    {
        if ( ! $this->orderWorkflow->can($order, $transition)) {
            return false;
        }

        $this->orderWorkflow->apply($order, $transition);

        return true;
    }
}