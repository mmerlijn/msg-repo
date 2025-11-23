<?php

namespace mmerlijn\msgRepo\Enums;


enum VektisType: string
{
    use StringEnumTrait;

    case ONDERNEMING = 'onderneming';
    case ZORGVERLENER = 'zorgverlener';
    case VESTIGING = 'vestiging';

    case NOT_FOUND = 'not_found';

    public function label(): string
    {
        return match ($this) {
            VektisType::ONDERNEMING => 'Onderneming',
            VektisType::ZORGVERLENER => 'Zorgverlener',
            VektisType::VESTIGING => 'Vestiging',
            VektisType::NOT_FOUND => 'Niet gevonden',
        };
    }
}
