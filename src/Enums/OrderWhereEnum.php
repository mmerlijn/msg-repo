<?php

namespace mmerlijn\msgRepo\Enums;

enum OrderWhereEnum: string
{
    case HOME = "HOME"; //Home
    case OTHER = "OTHER"; //Other
    case EMPTY = "";

    public static function set(OrderWhereEnum|string $status): self
    {
        if ($status instanceof OrderWhereEnum) {
            return $status;
        }
        return match (strtoupper($status)) {
            "HOME", "H", "L" => self::HOME,
            'OTHER', 'O' => self::OTHER,
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