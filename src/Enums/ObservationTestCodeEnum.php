<?php

namespace mmerlijn\msgRepo\Enums;

enum ObservationTestCodeEnum: string
{
    use StringEnumTrait;
    case YY = "YY"; //Prikopmerking
    case ZZ = "ZZ"; //Prikdatum
    case AI = "AI"; //Klinische opmerking
    case ONBZD = "ONBZD";
    case COVIDSYM = "COVIDSYM";

    case AF3 = "AF3";
    case HOME_VISIT_ADDRESS="HOME_VISIT_ADDRESS";

    public static function set(ObservationTestCodeEnum|string $control): self
    {
        if ($control instanceof self) {
            return $control;
        }
        $control = strtoupper($control);
        return match ($control) {
            "YY" => self::YY,
            "ZZ" => self::ZZ,
            "AI" => self::AI,
            "ONBZD" => self::ONBZD,
            "COVIDSYM" => self::COVIDSYM,
            "AF3" => self::AF3,
            "HOME_VISIT_ADDRESS" => self::HOME_VISIT_ADDRESS,
            default => throw new \InvalidArgumentException("Invalid ObservationTestCodeEnum value: " . $control),
        };
    }
    public function valueType(): string
    {
        return match ($this) {
            self::YY, self::ONBZD, self::ZZ, self::AI => "string",
            self::COVIDSYM => "bool",
        };
    }
    public function getTestCodeValue(): string
    {
        return match ($this) {
            self::YY => "opmerking thuisprikken",
            self::ZZ => "gewenste afnamedatum",
            self::AI => "Opmerkingen / klinische gegevens",
            self::ONBZD => "Onderzoek",
            self::COVIDSYM => "Covid-19 verdacht",
            self::AF3 => "Patient nuchter",
            self::HOME_VISIT_ADDRESS => "Huisbezoek adres",
        };
    }

}