<?php

namespace mmerlijn\msgRepo;

class Requester implements RepositoryInterface
{

    public function __construct(
        public string  $agbcode = "",
        public Name    $name = new Name,
        public string  $source = "",
        public Address $address = new Address,

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
        ];
    }
}