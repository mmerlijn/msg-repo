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
    case AF1="AF1";
    case AF5="AF5";
    case AFWA="AFWA";
    case OG="OG";
    case ME="ME";
    case MA= "MA";
    case TP1 = "TP1";
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
            "AF1" => self::AF1,
            "AF5" => self::AF5,
            "AFWA" => self::AFWA,
            "OG" => self::OG,
            "ME" => self::ME,
            "MA" => self::MA,
            "TP1" => self::TP1,
            "HOME_VISIT_ADDRESS" => self::HOME_VISIT_ADDRESS,
            default => throw new \InvalidArgumentException("Invalid ObservationTestCodeEnum value: " . $control),
        };
    }
    public function valueType(): string
    {
        return match ($this) {
            self::YY, self::ONBZD, self::ZZ, self::AI, self::AFWA => "string",
            self::COVIDSYM, self::AF3, self::AF5, self::OG, self::ME, self::MA, self::TP1 => "bool",
            default => "string",
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
            self::AF1 => "Afname locatie",
            self::AF5 => "Urine niet ingeleverd",
            self::AFWA => "Afwijkende afname",
            self::OG => "Ongestuwd geprikt",
            self::ME => "Meerling",
            self::MA => "Moeizame afname",
            self::TP1 => "Toestemming",
            self::HOME_VISIT_ADDRESS => "Huisbezoek adres",
        };
    }

}