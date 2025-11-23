<?php

namespace mmerlijn\msgRepo\Enums;

enum LangEnum: string
{
    use StringEnumTrait;

    case NL = 'NL';
    case EN = 'EN';
    case DE = 'DE';
    case FR = 'FR';
    case ES = 'ES';
    case IT = 'IT';


    public function label(): string
    {
        return match ($this) {
            LangEnum::NL => 'Nederlands',
            LangEnum::EN => 'English',
            LangEnum::DE => 'Deutsch',
            LangEnum::FR => 'Français',
            LangEnum::ES => 'Español',
            LangEnum::IT => 'Italiano',
        };
    }
}

