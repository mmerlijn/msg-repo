<?php

namespace mmerlijn\msgRepo;

use Exception;
use mmerlijn\msgRepo\Helpers\FormatPhone;

class Phone
{
    /**
     * @param string|null $number
     */
    public function __construct(public ?string $number = null)
    {
        if (is_null($this->number)) {
            $this->number = "";
        }
        //Remove all unwanted characters
        $this->number = str_replace([' ', '(0)', '-', '.'], '', $this->number);

        if ($this->number != "nb") {
            //Remove all non numeric characters
            $this->number = preg_replace('/[^0-9+]/', '', $this->number);

            //Strip country prefix by NL phone numbers
            if (str_starts_with($this->number, '+31') or str_starts_with($this->number, '0031')) {
                $this->number = preg_replace('/^(\+31|0031)/', '0', $this->number);
            }
        }
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
    public function withCountryCode(string $countryCode = "nl"): string
    {
        return FormatPhone::withCountryCode($this->number, $countryCode);
    }

    /**
     * return phone number for SMS sending
     *
     * @param string $countryCode
     * @return string
     * @throws Exception
     */
    public function forSms(string $countryCode = "nl"): string
    {
        return FormatPhone::forSMS($this->number, $countryCode);
    }

    public function canReceiveSms(): bool
    {
        return FormatPhone::isSmsPhone($this->number);
    }

    public function netNumber(string $city): self
    {
        if ($this->number)
            $this->number = FormatPhone::addCityNetNumber($this->number, $city);
        return $this;
    }

    /**
     * Used country codes
     *
     * @var array[]
     */
    private array $countryPrefixes = ["nl" => "+31", "be" => "+32", "fr" => "+33", "it" => "+39", "de" => "+49"];

}