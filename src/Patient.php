<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;

class Patient implements RepositoryInterface
{
    public function __construct(
        public string    $sex = "",
        public Name      $name = new Name,
        public Carbon    $dob = new Carbon,
        public string    $bsn = "",
        public Address   $address = new Address,
        public ?Address  $address2 = null,
        public Phones    $phones = new Phones,
        public Insurance $insurance = new Insurance,
        public Ids       $ids = new Ids,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'sex' => $this->sex,
            'name' => $this->name->toArray(),
            'dob' => $this->dob?->format('Y-m-d'),
            'bsn' => $this->bsn,
            'address' => $this->address->toArray(),
            'address2' => $this->address2?->toArray(),
            'phones' => $this->phones->toArray(),
            'insurance' => $this->insurance->toArray(),
            'ids' => $this->ids->toArray(),
        ];
    }
}