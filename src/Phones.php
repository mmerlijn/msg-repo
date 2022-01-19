<?php

namespace mmerlijn\msgRepo;

class Phones implements RepositoryInterface
{
    public array $phones = [];

    public function __construct(?Phone $phone = null)
    {
        if ($phone) {
            $this->add($phone);
        }
    }

    public function add(Phone $phone): self
    {
        if (!$this->exist($phone)) {
            $this->phones[] = $phone;
        }
        return $this;
    }

    public function toArray(): array
    {
        $array = [];
        foreach ($this->phones as $p) {
            $array[] = (string)$p;
        }
        return $array;
    }

    private function exist($phone): bool
    {
        foreach ($this->phones as $p) {
            if ($p->number == $phone->number)
                return true;
        }
        return false;
    }
}