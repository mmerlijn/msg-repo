<?php

namespace mmerlijn\msgRepo;

class Contact implements RepositoryInterface
{
    use HasPhoneTrait, HasAddressTrait, HasNameTrait;

    public function __construct(
        public string        $agbcode = "",
        public Name          $name = new Name,
        public string        $source = "",
        public ?Address      $address = null,
        public ?Phone        $phone = null,
        public string        $type = "",
        public ?Organisation $organisation = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'agbcode' => $this->agbcode,
            'source' => $this->source,
            'name' => $this->name->toArray(),
            'address' => $this->address?->toArray(),
            'phone' => (string)$this->phone,
            'type' => $this->type,
            'organisation' => $this->organisation?->toArray(),
        ];
    }

    public function setOrganisation(Organisation $organisation): self
    {
        $this->organisation = $organisation;
        return $this;
    }
}