<?php

namespace mmerlijn\msgRepo\Enums;

enum PatientSexEnum: string
{
    case FEMALE = "F";
    case MALE = "M";
    case OTHER = "X";
    case EMPTY = "";

    public static function set(string $sex): self
    {
        $sex = strtoupper($sex);
        if (in_array($sex, ['F', "V"])) {
            return self::FEMALE;
        } elseif (in_array($sex, ["m", "M"])) {
            return self::MALE;
        } else {
            return self::OTHER;
        }
    }

    public function getEdifact(): string
    {
        return match ($this) {
            self::FEMALE => "V",
            self::MALE => "M",
            self::OTHER => "X",
            default => ""
        };
    }

    public function namePrefix(): string
    {
        return match ($this) {
            self::FEMALE => "Mevr. ",
            self::MALE => "Dhr. ",
            self::OTHER => "",
            default => ""
        };
    }
}