<?php

namespace mmerlijn\msgRepo;

class Phone
{
    public function __construct(public string $number)
    {
        $this->number = preg_replace('/[^0-9]/', '', $this->number);
        
        if (strlen($this->number) > 10) //remove country prefix
            $this->number = "0" . preg_replace('/^([3-4]{1}\d{1}[0]?)/', '', $this->number);
    }

    public function __toString()
    {
        return $this->format();
    }

    public function format(): string
    {
        foreach ($this->netnumbers as $netnumber) {
            if (str_starts_with($this->number, $netnumber)) {
                $l = strlen($netnumber);
                $n = ($l == 2 or $l == 3) ? 4 : 3;
                return preg_replace('~^.{' . $l . '}|.{' . $n . '}(?!$)~', '$0 ', $this->number);
            }
        }
        return preg_replace('~^.{3}|.{4}(?!$)~', '$0 ', $this->number);
    }

    public function withCountryCode(string $countryCode = "nl")
    {
        return $this->countryPrefixes[strtolower($countryCode)] . preg_replace('/^(0)*/', '', $this->number);
    }

    public function smsPhone(string $countryCode = "nl"): string
    {
        $phone = $this->number;
        if (!preg_match('/(06){1}[0-9]{8}/', $phone)) {
            throw new \Exception('Not a mobile phone: ' . $phone);
        }
        if (!array_key_exists($countryCode, $this->countryPrefixes)) {
            throw new \Exception('Not a valid country code: ' . $countryCode);
        }
        return $this->withCountryCode($countryCode);

    }

    private $netnumbers = [
        "010", "0111", "0113", "0114", "0115", "0117", "0118", "013", "014", "015", "0161", "0162", "0164", "0165", "0166", "0167", "0168", "0172", "0174", "0180", "0181", "0182", "0183", "0184", "0186", "0187",
        "020", "0222", "0223", "0224", "0226", "0227", "0228", "0229", "023", "024", "0251", "0252", "0255", "026", "027", "0294", "0297", "0299",
        "030", "0313", "0314", "0315", "0316", "0317", "0318", "0320", "0321", "033", "0341", "0342", "0343", "0344", "0345", "0346", "0347", "0348", "035", "036", "038",
        "040", "0411", "0412", "0413", "0416", "0418", "043", "044", "045", "046", "0475", "0478", "0481", "0485", "0486", "0487", "0488", "0492", "0493", "0495", "0497", "0499",
        "050", "0511", "0512", "0513", "0514", "0515", "0516", "0517", "0518", "0519", "0521", "0522", "0523", "0524", "0525", "0527", "0528", "0529", "053", "0541", "0543", "0544", "0545", "0546", "0547", "0548", "055", "0561", "0562", "0566", "0570", "0571", "0572", "0573", "0575", "0577", "0578", "058", "0591", "0592", "0593", "0594", "0595", "0596", "0597", "0598", "0599",
        "06",
        "070", "071", "072", "073", "074", "075", "076", "077", "078", "079",
        "0800", "082", "084", "085", "087", "088",
        "0900", "0906", "0909", "091", "0970", "0971", "0972", "0973", "0974", "0975", "0976", "0977", "0978"
    ];

    private $countryPrefixes = ["nl" => "+31", "be" => "+32", "fr" => "+33", "it" => "+39", "de" => "+49"];

}