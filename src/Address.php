<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Helpers\FormatAddress;
use mmerlijn\msgRepo\Helpers\StripUnwanted;

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
        public string $postbus = "",
        public string $city = "",
        public string $street = "",
        public string $building = "",
        public string $building_nr = "",
        public string $building_addition = "",
        public string $country = "NL",
    )
    {
        $this->street = ucwords(strtolower(StripUnwanted::format($street ?? "", 'street')));
        $this->city = ucwords(strtolower(StripUnwanted::format($city ?? "", 'street')));
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
            'postbus' => $this->postbus,
            'country' => $this->country == 'NL' ? '' : $this->country
        ], $compact);
    }

    //backwards compatibility
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
}