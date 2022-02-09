<?php

namespace mmerlijn\msgRepo\Enums;

enum OrderStatusEnum: string
{
    case FINAL = "F";
    case CORRECTION = "C";
    case EMPTY = "";

    public static function set(string $status): self
    {
        return match (strtoupper($status)) {
            "F" => self::FINAL,
            "FINAL" => self::FINAL,
            'C' => self::CORRECTION,
            'CORRECTION' => self::CORRECTION,
            default => self::EMPTY,
        };
    }
}