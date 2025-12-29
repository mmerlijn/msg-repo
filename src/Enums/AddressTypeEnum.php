<?php

namespace mmerlijn\msgRepo\Enums;

enum AddressTypeEnum: string
{
    use StringEnumTrait;
    case HOME = "H";
    case CURRENT = "C"; //current or temporary address
    case POST = "M";

    case EMPTY = "";

    public static function set(AddressTypeEnum|string $type): self
    {
        if ($type instanceof AddressTypeEnum) {
            return $type;
        }
        $type = strtoupper($type);
        if (in_array($type, ['H', "HOME"])) {
            return self::HOME;
        } elseif (in_array($type, ["C", "CURRENT","T","TEMPORARY"])) {
            return self::CURRENT;
        } elseif (in_array($type, ["M", "POST"])) {
            return self::POST;
        } else {
            return self::EMPTY;
        }
    }
}