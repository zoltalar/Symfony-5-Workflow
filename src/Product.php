<?php

namespace App;

class Product
{
    /** @var string */
    protected $name;

    /** @var float */
    protected $price = 0;

    public function __construct(?string $name = null, float $price = 0)
    {
        $this->setName($name);
        $this->setPrice($price);
    }

    public function getName()
    {
        $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }
}