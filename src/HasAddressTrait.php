<?php

namespace mmerlijn\msgRepo;

trait HasAddressTrait
{
    public function setAddress(Address|array $address): self
    {
        if (gettype($address) == 'array') {
            $this->address = new Address(...$address);
        } else {
            $this->address = $address;
        }
        return $this;
    }
}