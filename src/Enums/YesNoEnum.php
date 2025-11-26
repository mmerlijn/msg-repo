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
            self::YES->value => self::YES->label(),
            self::NO->value => self::NO->label(),
            self::_->value => self::_->label(),
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
