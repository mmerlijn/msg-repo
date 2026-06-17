<?php

namespace mmerlijn\msgRepo\Enums;

use mmerlijn\msgRepo\TestCode;

enum AdmitReasonEnum: string
{
    use StringEnumTrait;
    case LABEDG001 = "LABEDG001";
    case LABEDG026 = "LABEDG026";
    case LABEDG027 = "LABEDG027";
    case LABEDG029 = "LABEDG029";
    case LABEDG037 = "LABEDG037";
    case LABEDG039 = "LABEDG039";
    case LABEDG040 = "LABEDG040";
    case LABEDG307 = "LABEDG307";

    case EMPTY = "";

    public static function set(AdmitReasonEnum|string $control): self
    {
        if ($control instanceof self) {
            return $control;
        }
        $control = strtoupper($control);
        return match ($control) {
            "LABEDG001" => self::LABEDG001,
            "LABEDG026" => self::LABEDG026,
            "LABEDG027" => self::LABEDG027,
            "LABEDG029" => self::LABEDG029,
            "LABEDG037" => self::LABEDG037,
            "LABEDG039" => self::LABEDG039,
            "LABEDG040" => self::LABEDG040,
            "LABEDG307" => self::LABEDG307,
            "EMPTY" => self::EMPTY,

        };
    }
    // ;
    public function testcode(): TestCode
    {
        return match ($this) {
            self::LABEDG001 => new TestCode(code: "LABEDG001",value:"laboratorium",source: "L"),
            self::LABEDG026 => new TestCode(code: "LABEDG026",value:"Verloskundige lab",source: "L"),
            self::LABEDG027 => new TestCode(code: "LABEDG027",value:"Verloskundige OGTT",source: "L"),
            self::LABEDG029 => new TestCode(code: "LABEDG029",value:"Medisch Microbiologie (banale kweek, SOA en feces)",source: "L"),
            self::LABEDG037 => new TestCode(code: "LABEDG037",value:"laboratorium",source: "L"),
            self::LABEDG039 => new TestCode(code: "LABEDG039",value:"Verloskundige lab",source: "L"),
            self::LABEDG040 => new TestCode(code: "LABEDG040",value:"Verloskundige OGTT",source: "L"),
            self::LABEDG307 => new TestCode(code: "LABEDG307",value:"Medisch Microbiologie Amsterdam (banale kweek, SOA en feces)",source: "L"),
            default => new TestCode(code: "LABEDG001",value:"laboratorium",source: "L")
        };
    }
}