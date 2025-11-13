<?php

namespace mmerlijn\msgRepo;

class Contact implements RepositoryInterface
{

    use HasPhoneTrait, HasAddressTrait, HasNameTrait, CompactTrait, HasOrganisationTrait;

    /**
     * @param string $agbcode
     * @param array|Name $name
     * @param string $source
     * @param array|Address $address
     * @param string|Phone $phone
     * @param string $type
     * @param array|Organisation $organisation
     * @param string $application
     * @param string $device
     * @param string $facility
     * @param string $location
     */
    public function __construct(
        public string             $agbcode = "",
        public array|Name         $name = new Name,
        public string             $source = "",
        public array|Address      $address = new Address,
        public string|Phone       $phone = new Phone,
        public string             $type = "",
        public array|Organisation $organisation = new Organisation,
        public string             $application = "",
        public string             $device = "",
        public string             $facility = "", //????
        public string             $location = "" //usefull for ORC.13
    )
    {
        $this->setName($name);
        $this->setAddress($address);
        $this->setPhone($phone);
        $this->setOrganisation($organisation);
    }

    /**
     * dump state
     *
     * @param bool $compact
     * @return array
     */
    public function toArray(bool $compact = false): array
    {
        return $this->compact([
            'agbcode' => $this->agbcode,
            'name' => $this->name->toArray($compact),
            'source' => $this->source,
            'address' => $this->address?->toArray($compact),
            'phone' => (string)$this->phone,
            'type' => $this->type,
            'organisation' => $this->organisation?->toArray($compact),
            'application' => $this->application,
            'device' => $this->device,
            'facility' => $this->facility, //???
            'location' => $this->location,
        ], $compact);
    }

    //backwards compatibility
    public function fromArray(array $data): Contact
    {
        return new Contact(...$data);
    }


}