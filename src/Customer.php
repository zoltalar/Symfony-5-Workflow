<?php

namespace App;

class Customer
{
    /** @var string */
    protected $name;

    public function __construct(?string $name = null)
    {
        $this->setName($name);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}