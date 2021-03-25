<?php

namespace App;

use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;

class Order
{
    private $id;
    private $state;
    protected $customer;
    protected $picker;
    protected $items = [];

    public function __construct(?int $id = null)
    {
        $this->setId($id);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state): self
    {
        $expectedClass = MethodMarkingStore::class;
        $callerClass = debug_backtrace()[1]['class'] ?? debug_backtrace()[0]['class'] ?? '';

        if ($expectedClass != $callerClass) {
            throw new \Exception('Order state can only be set from workflow');
        }

        $this->state = $state;

        return $this;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function setPicker(Picker $picker): self
    {
        $this->picker = $picker;

        return $this;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }
}