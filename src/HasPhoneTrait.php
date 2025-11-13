<?php

namespace mmerlijn\msgRepo;

trait HasPhoneTrait
{

    /**
     * set phone for current object
     *
     * @param Phone|string $phone
     * @return HasPhoneTrait|Contact|Insurance|Organisation
     */
    public function setPhone(Phone|string $phone): self
    {
        if (gettype($phone) == "string") {
            $this->phone = new Phone($phone);
        } else {
            $this->phone = $phone;
        }
        return $this;
    }
}