<?php

namespace mmerlijn\msgRepo;

trait HasNameTrait
{

    /**
     * Set name for current object
     *
     * @param Name|array $name
     * @return Contact|HasNameTrait|Patient
     */
    public function setName(Name|array $name = new Name()): self
    {
        if (gettype($name) == 'array') {
            $this->name = new Name(...$name);
        } else {
            $this->name = $name;
        }
        return $this;
    }
}