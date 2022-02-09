<?php

namespace mmerlijn\msgRepo\Enums;

enum OrderWhereEnum: string
{
    case HOME = "HOME"; //Home
    case OTHER = "OTHER"; //Other
    case EMPTY = "";

    public static function set(string $status): self
    {
        return match (strtoupper($status)) {
            "HOME" => self::HOME,
            "H" => self::HOME,
            "L" => self::HOME,
            'OTHER' => self::OTHER,
            'O' => self::OTHER,
            default => self::EMPTY,
        };
    }

    public function getHl7(): string
    {
        return match ($this) {
            self::HOME => "L",
            self::OTHER => "O",
            default => ""
        };
    }
}