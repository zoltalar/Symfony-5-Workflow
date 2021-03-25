<?php

namespace App;

class Picker
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

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }
}