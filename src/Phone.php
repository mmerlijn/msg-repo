<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Helpers\FormatPhone;

class Phone
{
    /**
     * @param string $number
     */
    public function __construct(public string $number)
    {
        $this->number = preg_replace('/[^0-9]/', '', $this->number);

        if (strlen($this->number) > 10) //remove country prefix
            $this->number = "0" . preg_replace('/^([0]*[3-4]{1}\d{1}[0]?)/', '', $this->number);
    }

    /**
     * dump formatted
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format();
    }

    /**
     * return formatted
     *
     * @return string
     */
    public function format(): string
    {
        return FormatPhone::format($this->number);
    }

    /**
     * return with country code
     *
     * @param string $countryCode
     * @return string
     */
    public function withCountryCode(string $countryCode = "nl")
    {
        return FormatPhone::withCountryCode($this->number, $countryCode);
    }

    /**
     * return phone number for SMS sending
     *
     * @param string $countryCode
     * @return string
     * @throws \Exception
     */
    public function forSms(string $countryCode = "nl"): string
    {
        return FormatPhone::forSMS($this->number, $countryCode);
    }

    public function netNumber(string $city): void
    {
        $this->number = FormatPhone::addCityNetNumber($this->number, $city);
    }

    /**
     * Used country codes
     *
     * @var array[]
     */
    private $countryPrefixes = ["nl" => "+31", "be" => "+32", "fr" => "+33", "it" => "+39", "de" => "+49"];

}