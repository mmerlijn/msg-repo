<?php

namespace mmerlijn\msgRepo\Enums;

enum PatientSexEnum: string
{
    use StringEnumTrait;
    case FEMALE = "F";
    case MALE = "M";
    case OTHER = "U";
    case EMPTY = "";

    public static function set(PatientSexEnum|string $sex): self
    {
        if ($sex instanceof PatientSexEnum) {
            return $sex;
        }
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
            self::OTHER => "U",
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
    public static function selectOptions(): array
    {
        return ['M' => 'Man', 'F' => 'Vrouw', 'U' => 'Anders'];
    }
}