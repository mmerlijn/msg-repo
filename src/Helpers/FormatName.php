<?php

namespace mmerlijn\msgRepo\Helpers;

class FormatName
{

    /** Split prefix from name
     *
     * @param string $lastname
     * @param string $prefix
     * @return array
     */
    public static function nameSplitter(string $lastname, string $prefix = ""): array
    {

        $parts = explode(" ", preg_replace('/,/', " ", $lastname));
        if (count($parts) > 1) {
            $lastname = "";
            foreach ($parts as $part) {
                if (trim($part)) {
                    if (in_array(strtolower($part), static::$prefixes)) { //is prefix
                        $prefix .= " " . strtolower($part);
                    } else { //belongs to lastname
                        $lastname .= " " . $part;
                    }
                }
            }
        }
        return ['lastname' => trim($lastname), 'prefix' => trim(implode(" ", array_unique(explode(" ", $prefix))))];
    }


    /**
     * Common dutch name prefixes
     *
     * @var array
     */
    private static array $prefixes = ['aan', 'af', 'bij', 'de', 'den', 'der', 'd\'', 'het', '\'t', 'in', 'onder', 'op', 'over', '\'s', 'te', 'ten', 'ter', 'tot', 'uit', 'uijt', 'van', 'ver', 'voor',
        'a', 'al', 'am', 'auf', 'aus', 'ben', 'bin', 'da', 'dal', 'dalla', 'della', 'das', 'die', 'den', 'der', 'des', 'deca', 'degli', 'dei', 'del', 'di', 'do', 'don', 'dos', 'du', 'el',
        'i', 'im', 'l', 'la', 'las', 'le', 'les', 'lo', 'los', 'o\'', 'tho', 'thoe', 'thor', 'toe', 'unter', 'vom', 'von', 'vor', 'zu', 'zum', 'zur'];
}