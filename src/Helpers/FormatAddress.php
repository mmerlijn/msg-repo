<?php

namespace mmerlijn\msgRepo\Helpers;

use mmerlijn\msgRepo\Address;

class FormatAddress
{

    public static function getAddress(Address $address): array
    {
        if (!$address->building and !$address->building_nr) {
            preg_match('/^([^\d]+)\s*(\d*)(.*)$/i', $address->street, $matches);
            // $matches[1] will contain the non-numeric part (street name)
            // $matches[2] will contain the numeric part (house number)
            //var_dump($matches);
            //exit();
            $a['street'] = isset($matches[1]) ? trim($matches[1]) : '';
            $a['building'] = isset($matches[2]) ? trim($matches[2] . ($matches[3] ?? "")) : '';
            $a['building_nr'] = self::extractNumericPart($a['building']);
            $a['building_addition'] = self::extractAfterNumericPart($a['building']);
            return $a;
        }
        if (!$address->building) {
            if ($address->building_addition and strstr($address->building_nr, $address->building_addition)) {
                $a['building'] = trim($address->building_nr);
            } else {
                $a['building'] = trim($address->building_nr . " " . $address->building_addition);
            }
            $a['street'] = $address->street;
            $a['building_nr'] = self::extractNumericPart($a['building']);
            $a['building_addition'] = self::extractAfterNumericPart($a['building']);
            return $a;
        }
        if (!$address->building_nr) {
            $a['building_nr'] = self::extractNumericPart(str_replace(' ', '-', trim($address->building)));
            //$a['building_addition'] = self::extractNonNumericPart($address->building);
            if (!$a['building_nr']) {
                preg_match('/^([^\d]+)\s*(\d*).*$/i', $address->street, $matches);
                // $matches[1] will contain the non-numeric part (street name)
                // $matches[2] will contain the numeric part (house number)
                $a['street'] = isset($matches[1]) ? trim($matches[1]) : '';
                $a['building'] = isset($matches[2]) ? trim($matches[2] . " " . self::extractAfterNumericPart($address->building)) : '';
                $a['building_nr'] = self::extractNumericPart($a['building']);
                $a['building_addition'] = self::extractAfterNumericPart($a['building']);
            } else {
                $a['street'] = $address->street;
                $a['building'] = $address->building;
                $a['building_nr'] = self::extractNumericPart($a['building']);
                $a['building_addition'] = self::extractAfterNumericPart($a['building']);
            }

            return $a;
        }
        $a['building_nr'] = self::extractNumericPart($address->building);
        $a['building_addition'] = self::extractAfterNumericPart($address->building);
        return ['street' => $address->street, 'building' => $address->building, 'building_nr' => $a['building_nr'], 'building_addition' => $a['building_addition']];
    }

    //  "4 a" => a
    private static function extractAfterNumericPart($inputString): string
    {
        // Use regular expression to remove any numeric characters from the beginning of the string
        return trim(preg_replace('/^[\d]+/', '', $inputString), "- \n\r\t\v\x00");
    }

    //  "4 a" => 4
    private static function extractNumericPart($inputString): string
    {
        preg_match('/^(\d+)[^\d]*.*$/', $inputString, $matches);
        // $matches[1] will contain the numeric part
        return isset($matches[1]) ? trim($matches[1]) : '';
    }
}