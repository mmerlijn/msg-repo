<?php

namespace mmerlijn\msgRepo\Enums;

enum OrderStatusEnum: string
{
    case FINAL = "F";
    case CORRECTION = "C";
    case EMPTY = "";

    public static function set(OrderStatusEnum|string $status): self
    {
        if ($status instanceof OrderStatusEnum) {
            return $status;
        }
        return match (strtoupper($status)) {
            "F", "FINAL" => self::FINAL,
            'C', 'CORRECTION' => self::CORRECTION,
            default => self::EMPTY,
        };
    }
}