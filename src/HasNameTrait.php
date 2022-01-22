<?php

namespace mmerlijn\msgRepo;

trait HasNameTrait
{
    public function setName(Name|array $name): self
    {
        if (gettype($name) == 'array') {
            $this->name = new Name(...$name);
        } else {
            $this->name = $name;
        }
        return $this;
    }
}