<?php

namespace mmerlijn\msgRepo\Helpers;

class StripUnwanted
{
    public static function format(string $input, $type = 'names'): string
    {
        if ($type == 'names') {
            $output = preg_replace('/-/', '', $input);
            $output = preg_replace('/(\*.*\**)/', '', $output);
            $output = preg_replace('/\\\.*\\\/', '', $output);
            $output = preg_replace('/\./', '', $output);
            $output = preg_replace('/Ã©/', 'é', $output);
            $output = preg_replace('/Ã¨/', 'è', $output);
            $output = preg_replace('/Ã«/', 'ë', $output);
            $output = preg_replace('/Ã¡/', 'á', $output);
            $output = preg_replace('/Ã /', 'à', $output);
            $output = preg_replace('/Ã¤/', 'ä', $output);
            $output = preg_replace('/Ã³/', 'ó', $output);
            $output = preg_replace('/Ã¶/', 'ö', $output);
            $output = preg_replace('/Ã¶/', 'ö', $output);
            $output = preg_replace('/Ãº/', 'ú', $output);
            $output = preg_replace('/Ã¼/', 'ü', $output);
            $output = preg_replace('/Ã±/', 'ñ', $output);
            $output = preg_replace('/Ã‡/', 'Ç', $output);
            $output = preg_replace('/Ã§/', 'ç', $output);
            $output = preg_replace('/Ã€/', 'À', $output);
            $output = preg_replace('/Ã‰/', 'É', $output);
            $output = preg_replace('/ÃŠ/', 'Ê', $output);
            $output = preg_replace('/Ã–/', 'Ö', $output);
            $output = preg_replace('/Ãœ/', 'Ü', $output);
            $output = preg_replace('/Ã“/', 'Ó', $output);
            $output = preg_replace('/Ãš/', 'Ú', $output);
            $output = preg_replace('/Ã€/', 'À', $output);
            $output = preg_replace('/ÃŒ/', 'Ì', $output);
            $output = preg_replace('/Ã‰/', 'É', $output);
            $output = preg_replace('/Ã€/', 'À', $output);
            $output = preg_replace('/Ã’/', 'Ò', $output);
            $output = preg_replace('/Ã‰/', 'É', $output);
            $output = preg_replace('/Ãˆ/', 'È', $output);
            $output = preg_replace('/Ã’/', 'Ò', $output);
            $output = preg_replace('/Ã’/', 'Ò', $output);
            $output = preg_replace('/ÃŒ/', 'Ì', $output);
            $output = preg_replace('/Ã’/', 'Ò', $output);
            $output = preg_replace('/Ã™/', 'Ù', $output);
            $output = preg_replace('/ÃŽ/', 'Î', $output);
            $output = preg_replace('/Ã‚/', 'Â', $output);
            $output = preg_replace('/Ã‰/', 'É', $output);
            $output = preg_replace('/Ã‹/', 'Ë', $output);
            $output = preg_replace('/ÃŽ/', 'Î', $output);
            $output = preg_replace('/Ã‰/', 'É', $output);

            return trim($output);
        } elseif ($type == 'street') {
            $output = preg_replace('/-/', '', $input);
            $output = preg_replace('/(\*.*\**)/', '', $output);
            $output = preg_replace('/\\\.*\\\/', '', $output);
            return trim($output);
        } else {
            $output = preg_replace('/\\\.br\\\/', '. ', $input);
            return $output;
        }
    }
}