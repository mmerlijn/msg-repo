<?php

namespace mmerlijn\msgRepo\Enums;

enum ValueTypeEnum: string
{
    case ST = 'ST';
    case NM = 'NM';
    case CE = 'CE';

    case FT = 'FT'; // Formatted Text

    public static function isValueType(mixed $value,array $values): ValueTypeEnum
    {
        if(!empty($values)){
            return ValueTypeEnum::CE;
        }
        if(is_numeric($value)){
            return ValueTypeEnum::NM;
        }
        return ValueTypeEnum::ST;
    }
}
