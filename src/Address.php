<?php

namespace mmerlijn\msgRepo;

class Address implements RepositoryInterface
{
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
        if (!$this->building_nr and !$this->building_addition) {
            $this->buildingNrSplitter($this->building);
        } elseif (!$this->building) {
            $this->building = $this->building_nr . " " . $this->building_addition;
        }
        $this->street = ucwords(strtolower($this->street));
        $this->city = ucwords(strtolower($this->city));
    }

    public function toArray(): array
    {
        return [
            'postcode' => $this->postcode,
            'city' => $this->city,
            'street' => $this->street,
            'building' => $this->building,
            'building_nr' => $this->building_nr,
            'building_addition' => $this->building_addition,
            'postbus' => $this->postbus,
            'country' => $this->country,
        ];
    }

    private function buildingNrSplitter(string $building)
    {
        $this->building_nr = preg_replace('/^(\d+)(.*)/', '$1', $building);
        $this->building_addition = trim(preg_replace('/^(\d+)(.*)/', '$2', $building));
        $this->building = trim($this->building_nr . " " . $this->building_addition);
    }

    public function __toString(): string
    {
        return $this->street . " " . $this->building . "\n" . $this->postcode . " " . $this->city;
    }
}