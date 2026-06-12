<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Enums\AddressTypeEnum;
use mmerlijn\msgRepo\Helpers\FormatAddress;


class Address implements RepositoryInterface
{
    use CompactTrait;

    /**
     * @param string $postcode
     * @param string $postbus
     * @param string $city
     * @param string $street
     * @param string $building
     * @param string $building_nr
     * @param string $building_addition
     * @param string $country
     */
    public function __construct(
        public string $postcode = "",
        public string $city = "",
        public string $street = "",
        public string $building = "",
        public string $building_nr = "",
        public string $building_addition = "",
        public string $country = "NL",
        public string $postbus = "",
        public ?AddressTypeEnum $type = null,
    )
    {
        $this->postcode = $postcode ?? "";
        $this->street = ucwords(strtolower($street ?? ""));
        $this->city = ucwords(strtolower($city ?? ""));
        $this->building = $building ?? "";
        $this->building_nr = $building_nr ?? "";
        $this->building_addition = $building_addition ?? "";

        $a = FormatAddress::getAddress($this);
        $this->street = $a['street'];
        $this->building = $a['building'];
        $this->building_nr = $a['building_nr'];
        $this->building_addition = $a['building_addition'];
    }


    /** state
     *
     * @param bool $compact
     * @return array
     */
    public function toArray(bool $compact = false): array
    {
        return $this->compact([
            'postcode' => $this->postcode,
            'city' => $this->city,
            'street' => $this->street,
            'building' => $this->building,
            'building_nr' => $this->building_nr,
            'building_addition' => $this->building_addition,
            'country' => $this->country,
            'postbus' => $this->postbus,
        ], $compact);
    }

    /** create from array
     *
     * @param array $data
     * @return Address
     */
    public function fromArray(array $data): Address
    {
        return new Address(...$data);
    }


    /** format address to string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->street . " " . $this->building . "\n" . $this->postcode . " " . $this->city;
    }

    public function hasData():bool
    {
        return $this->street !== "" || $this->building !== "" || $this->postcode !== "" || $this->city !== "";
    }
}