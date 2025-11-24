<?php

namespace mmerlijn\msgRepo\Enums;

enum ValueTypeEnum: string
{
    use StringEnumTrait;
    case ST = 'ST';
    case NM = 'NM';
    case CE = 'CE';

    case FT = 'FT'; // Formatted Text

    public static function isValueType(mixed $value,array $values, ValueTypeEnum|string $current): ValueTypeEnum
    {
        if(!empty($values)){
            return ValueTypeEnum::CE;
        }
        if($current instanceof ValueTypeEnum){
            return $current;
        }
        return ValueTypeEnum::tryFrom($current) ??
            (is_numeric($value) ? ValueTypeEnum::NM : ValueTypeEnum::ST);
    }
}
