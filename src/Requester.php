<?php

namespace mmerlijn\msgRepo;

class Requester implements RepositoryInterface
{

    public function __construct(
        public string  $agbcode = "",
        public Name    $name = new Name,
        public string  $source = "",
        public Address $address = new Address,
        public Phone   $phone = new Phone(""),
        public string  $type = "",
    )
    {
    }

    public function toArray(): array
    {
        return [
            'agbcode' => $this->agbcode,
            'source' => $this->source,
            'name' => $this->name->toArray(),
            'address' => $this->address->toArray(),
            'phone' => (string)$this->phone,
            'type' => $this->type,
        ];
    }

    public function setPhone(Phone $phone): self
    {
        $this->phones = $phone;
        return $this;
    }
}