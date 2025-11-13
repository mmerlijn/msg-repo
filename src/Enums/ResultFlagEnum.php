<?php

namespace mmerlijn\msgRepo\Enums;

enum ResultFlagEnum: string
{
    case HIGH = "H"; //new
    case LOW = "L"; //Cancel
    case EMPTY = "";


    public static function set(ResultFlagEnum|string $flag): self
    {
        if ($flag instanceof ResultFlagEnum) {
            return $flag;
        }
        return match (strtoupper($flag)) {
            "H", "HIGH", ">" => self::HIGH,
            "LOW", "L", "<" => self::LOW,
            default => self::EMPTY,
        };
    }

    public function getEdifact(): string
    {
        return match ($this) {
            self::HIGH => ">",
            self::LOW => "<",
            default => ""
        };
    }
}