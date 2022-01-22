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
        public string        $application = "",
        public string        $device = "",
        public string        $facility = "", //????
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
            'application' => $this->application,
            'device' => $this->device,
            'facility' => $this->facility, //???
        ];
    }

    public function setOrganisation(Organisation|array $organisation = new Organisation()): self
    {
        if (gettype($organisation) == "array") {
            $organisation = new Organisation(...$organisation);
        }
        $this->organisation = $organisation;
        return $this;
    }
}