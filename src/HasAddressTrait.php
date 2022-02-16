<?php

namespace mmerlijn\msgRepo;

trait HasAddressTrait
{

    /**
     * set the address for current object
     *
     * @param Address|array $address
     * @return $this
     */
    public function setAddress(Address|array $address = new Address()): self
    {
        if (gettype($address) == 'array') {
            $this->address = new Address(...$address);
        } else {
            $this->address = $address;
        }
        return $this;
    }
}