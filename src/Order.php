<?php

namespace App;

class Order
{
    public $state;
    public $customer;
    public $picker;
    public $items;

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }
}