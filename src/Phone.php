<?php

namespace mmerlijn\msgRepo;

class Phone
{
    public function __construct(public string $number)
    {
        $this->number = preg_replace('/[^0-9]/', '', $this->number);
    }

    public function __toString()
    {
        return $this->number;
    }
}