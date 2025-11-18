<?php

namespace mmerlijn\msgRepo\Helpers;

class BsnValidator
{
    public static function validate(string $bsn): bool
    {
        $bsn = trim($bsn);
        if ($bsn) {
            // lijst met nummers die qua check kloppen, maar toch niet geldig zijn
            $aInvalid = array('111111110',
                '999999990',
                '000000000');
            $bsn = strlen($bsn) < 9 ? '0' . $bsn : $bsn;
            if (strlen($bsn) != 9 || !ctype_digit($bsn) || in_array($bsn, $aInvalid)) {
                return false;
            }
            $result = 0;
            $products = range(9, 2);
            $products[] = -1;

            foreach (str_split($bsn) as $i => $char) {
                $result += (int) $char * $products[$i];
            }

            return $result % 11 === 0;
        }
        return true;
    }
}