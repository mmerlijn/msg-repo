<?php

namespace mmerlijn\msgRepo\Enums;

enum ResultFlagEnum: string
{
    case HIGH = "H"; //new
    case LOW = "L"; //Cancel
    case EMPTY = "";


    public static function set(string $flag): self
    {
        return match (strtoupper($flag)) {
            "H" => self::HIGH,
            "HIGH" => self::HIGH,
            "LOW" => self::LOW,
            "L" => self::LOW,
            default => self::EMPTY,
        };
    }
}