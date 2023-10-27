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