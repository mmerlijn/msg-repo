<?php

namespace mmerlijn\msgRepo;

class Contact implements RepositoryInterface
{

    use HasPhoneTrait, HasAddressTrait, HasNameTrait;

    /**
     * @param string $agbcode
     * @param Name $name
     * @param string $source
     * @param Address|null $address
     * @param Phone|null $phone
     * @param string $type
     * @param Organisation|null $organisation
     * @param string $application
     * @param string $device
     * @param string $facility
     */
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

    /**
     * dump state
     *
     * @return array
     */
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

    public function fromArray(array $data): Contact
    {
        $this->agbcode = $data['agbcode'];
        $this->source = $data['source'];
        $this->setName($data['name']);;
        if (!empty($data['address'])) {
            $this->setAddress($data['address']);
        }
        $this->setPhone($data['phone']);
        $this->type = $data['type'];
        if (!empty($data['organisation'])) {
            $this->setOrganisation($data['organisation']);
        }
        $this->application = $data['application'];
        $this->device = $data['device'];
        $this->facility = $data['facility'];
        return $this;
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