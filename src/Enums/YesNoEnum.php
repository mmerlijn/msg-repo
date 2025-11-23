<?php

namespace mmerlijn\msgRepo\Enums;

enum YesNoEnum: string
{
    use StringEnumTrait;

    case YES = "Y";
    case NO = "N";
    case _ = "_";

    public function label(): string
    {
        return match ($this) {
            YesNoEnum::YES => 'Ja',
            YesNoEnum::NO => 'Nee',
            YesNoEnum::_ => 'Onbekend',
        };
    }

    public static function labels(): array
    {
        return [
            'YES' => 'Ja',
            'NO' => 'Nee',
            '_' => 'Onbekend',
        ];
    }

    public function getBool(): bool
    {
        return match ($this) {
            YesNoEnum::YES => true,
            YesNoEnum::NO => false,
            YesNoEnum::_ => null,
        };
    }
}
