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
            "H" => self::HOME,
            "L" => self::HOME,
            'O' => self::OTHER,
            default => self::EMPTY,
        };
    }
}