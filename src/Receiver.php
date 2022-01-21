<?php

namespace mmerlijn\msgRepo;

class Receiver implements RepositoryInterface
{
    public function __construct(
        public string   $name = "",
        public string   $application = "",
        public string   $facility = "",
        public string   $agbcode = "",
        public ?Address $address = null,
        public ?Phone   $phone = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'application' => $this->application,
            'facility' => $this->facility,
            'agbcode' => $this->agbcode,
            'address' => $this->address?->toArray(),
            'phone' => (string)$this->phone,
        ];
    }
}