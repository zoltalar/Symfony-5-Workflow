<?php

namespace App;

use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;

class Order
{
    private $state;
    protected $customer;
    protected $picker;
    protected $items = [];

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $expectedClass = MethodMarkingStore::class;
        $callerClass = debug_backtrace()[1]['class'] ?? debug_backtrace()[0]['class'] ?? '';

        if ($expectedClass != $callerClass) {
            throw new \Exception('Order state can only be set from workflow');
        }

        $this->state = $state;
    }

    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    public function setPicker(Picker $picker)
    {
        $this->picker = $picker;

        return $this;
    }

    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }
}