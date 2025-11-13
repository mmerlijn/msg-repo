<?php

namespace mmerlijn\msgRepo\Enums;

enum ValueType: string
{
    case ST = 'ST';
    case NM = 'NM';
    case CE = 'CE';

    public static function isValueType(mixed $value,array $values): ValueType
    {
        if(!empty($values)){
            return ValueType::CE;
        }
        if(is_numeric($value)){
            return ValueType::NM;
        }
        return ValueType::ST;
    }
}
