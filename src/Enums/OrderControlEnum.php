<?php

namespace mmerlijn\msgRepo\Enums;

enum OrderControlEnum: string
{
    case NEW = "NEW"; //new
    case CANCEL = "CANCEL"; //Cancel
    case CHANGE = "CHANGE"; //CHANGE
    case RESULT = "RESULT"; //RESULT
    case EMPTY = "";

    public static function set(OrderControlEnum|string $control): self
    {
        if ($control instanceof self) {
            return $control;
        }
        $control = strtoupper($control);
        return match ($control) {
            "NEW" => self::NEW,
            "NW" => self::NEW,
            "N" => self::NEW,
            "CANCEL" => self::CANCEL,
            "CA" => self::CANCEL,
            "C" => self::CANCEL,
            "CHANGE" => self::CHANGE,
            "XO" => self::CHANGE,
            "RESULT" => self::RESULT,
            "RE" => self::RESULT,
        };
    }

    public function getHl7(): string
    {
        return match ($this) {
            self::NEW => "NW",
            self::CANCEL => "CA",
            self::CHANGE => "XO",
            self::RESULT => "RE",
            default => "NW"
        };
    }
}