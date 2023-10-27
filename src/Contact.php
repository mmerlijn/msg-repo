<?php

namespace mmerlijn\msgRepo;

class Contact implements RepositoryInterface
{

    use HasPhoneTrait, HasAddressTrait, HasNameTrait, CompactTrait;

    /**
     * @param string $agbcode
     * @param array|Name $name
     * @param string $source
     * @param array|Address|null $address
     * @param string|Phone|null $phone
     * @param string $type
     * @param array|Organisation|null $organisation
     * @param string $application
     * @param string $device
     * @param string $facility
     * @param string $location
     */
    public function __construct(
        public string                  $agbcode = "",
        public array|Name              $name = new Name,
        public string                  $source = "",
        public null|array|Address      $address = null,
        public null|string|Phone       $phone = null,
        public string                  $type = "",
        public null|array|Organisation $organisation = null,
        public string                  $application = "",
        public string                  $device = "",
        public string                  $facility = "", //????
        public string                  $location = "" //usefull for ORC.13
    )
    {
        if (is_array($name)) $this->name = new Name(...$name);
        if (is_array($address)) $this->address = new Address(...$address);
        if (is_string($phone)) $this->phone = new Phone($phone);
        if (is_array($organisation)) $this->organisation = new Organisation(...$organisation);
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
            'source' => $this->source,
            'name' => $this->name->toArray($compact),
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

    /**
     * set contacts organisation
     *
     * @param Organisation|array $organisation
     * @return $this
     */
    public function setOrganisation(Organisation|array $organisation = new Organisation()): self
    {
        if (gettype($organisation) == "array") {
            $organisation = (new Organisation)->fromArray($organisation);
        }
        $this->organisation = $organisation;
        return $this;
    }
}