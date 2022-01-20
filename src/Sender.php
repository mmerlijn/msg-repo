<?php

namespace mmerlijn\msgRepo;

class Sender implements RepositoryInterface
{
    public function __construct(
        public string   $name = "",
        public string   $application = "",
        public string   $device = "",
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
            'device' => $this->device,
            'facility' => $this->facility,
            'agbcode' => $this->agbcode,
            'address' => $this->address->toArray(),
            'phone' => (string)$this->phone,
        ];
    }
}