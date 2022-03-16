<?php

namespace mmerlijn\msgRepo\Helpers;

class FormatPhone
{

    /** Format phone number readable
     *
     * @param string $number
     * @return string
     */
    public static function format(string $number): string
    {
        foreach (static::$netnumbers as $netnumber) {
            if (str_starts_with($number, $netnumber)) {
                $l = strlen($netnumber);
                $n = ($l == 2 or $l == 3) ? 4 : 3;
                return preg_replace('~^.{' . $l . '}|.{' . $n . '}(?!$)~', '$0 ', $number);
            }
        }
        return preg_replace('~^.{3}|.{4}(?!$)~', '$0 ', $number);
    }


    /** Format phone for sending SMS
     *
     * @param string $number
     * @param string $countryCode
     * @return string
     * @throws \Exception
     */
    public static function forSMS(string $number, string $countryCode = "nl"): string
    {
        if (!preg_match('/(06){1}[0-9]{8}/', $number)) {
            throw new \Exception('Not a mobile phone: ' . $number);
        }
        if (!array_key_exists($countryCode, static::$countryPrefixes)) {
            throw new \Exception('Not a valid country code: ' . $countryCode);
        }
        return static::withCountryCode($number, $countryCode);
    }

    public static function isSmsPhone(string $number): bool
    {
        if (!preg_match('/(06){1}[0-9]{8}/', $number)) {
            return false;
        }
        return true;
    }

    /** prefix phone number with country code
     *
     * @param string $number
     * @param string $countryCode
     * @return string
     */
    public static function withCountryCode(string $number, string $countryCode = "nl"): string
    {
        return static::$countryPrefixes[strtolower($countryCode)] . preg_replace('/^(0)*/', '', $number);
    }

    public static function addCityNetNumber(string $number, string $city): string
    {
        if (!preg_match('/^(0){1}/', $number) and strlen($number) < 10) {
            return static::cityNetNumbers($city) . $number;
        }
        return $number;
    }

    /**
     * Common dutch netnumbers
     *
     * @var array
     */
    private static array $netnumbers = [
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
    private static array $countryPrefixes = ["nl" => "+31", "be" => "+32", "fr" => "+33", "it" => "+39", "de" => "+49"];


    private static function cityNetNumbers($city): string
    {
        return match (strtolower($city)) {
            "purmerend",
            "monnickendam",
            "marken",
            "edam",
            "graft",
            "hobrede",
            "katwoude",
            "kwadijk",
            "noordbeemster",
            "westbeemster",
            "oosthuizen",
            "purmer",
            "purmerland",
            "volendam",
            "wijdewormer",
            "middenbeemster",
            "zuidoostbeemster" => "0299",
            "hoorn", "zwaag" => "0229",
            "amstelveen",
            "broek in waterland",
            "amsterdam",
            "diemen",
            "ilpendam",
            "landsmeer",
            "watergang",
            "halfweg" => "020",
            "castricum",
            "bakkem",
            "uitgeest",
            "akersloot",
            "beverwijk",
            "heemskerk" => "0251",
            "alkmaar",
            "egmond aan den hoef",
            "egmond aan zee",
            "egmond-binnen",
            "groet",
            "heerhugowaard",
            "heiloo",
            "limmen",
            "zuidschermer" => "072",
            "ijmuiden" => "0255",
            "assendelft",
            "jisp",
            "koog aan de zaan",
            "krommenie",
            "oostzaan",
            "west-grafdijk",
            "westknollendam",
            "westzaan",
            "wormer",
            "wormerveer",
            "zaandam",
            "zaandijk",
            "zaanstad" => "075",
            "haarlem", "heemstede" => "023",
            default => ""
        };
    }


}