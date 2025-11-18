<?php

namespace mmerlijn\msgRepo\Helpers;

class AgbcodeValidator
{
    public static function validate(string $agbcode): bool
    {
        // Dutch AGB code validation: 8 digits
        if (!preg_match('/^\d{6}$/', trim($agbcode))) {
            return false;
        }
        return true;
    }
}