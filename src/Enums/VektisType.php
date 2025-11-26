<?php

namespace mmerlijn\msgRepo\Enums;


enum VektisType: string
{
    use StringEnumTrait;

    case ONDERNEMING = 'onderneming';
    case ZORGVERLENER = 'zorgverlener';
    case VESTIGING = 'vestiging';

    case NOT_FOUND = 'not_found';

    case UNKNOWN = 'unknown';

    public function label(): string
    {
        return match ($this) {
            VektisType::ONDERNEMING => 'Onderneming',
            VektisType::ZORGVERLENER => 'Zorgverlener',
            VektisType::VESTIGING => 'Vestiging',
            VektisType::NOT_FOUND => 'Niet gevonden',
            VektisType::UNKNOWN => 'Onbekend',
        };
    }

    public static function labels(): array
    {
        return [
            VektisType::ONDERNEMING->value => VektisType::ONDERNEMING->label(),
            VektisType::ZORGVERLENER->value => VektisType::ZORGVERLENER->label(),
            VektisType::VESTIGING->value => VektisType::VESTIGING->label(),
            VektisType::NOT_FOUND->value => VektisType::NOT_FOUND->label(),
            VektisType::UNKNOWN->value => VektisType::UNKNOWN->label(),
        ];
    }
}
