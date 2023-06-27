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