<?php

use mmerlijn\msgRepo\Enums\ValueTypeEnum;

it('test FT type', function ($value,$values,$current, $expected) {
    if($current!==null) {
        expect(ValueTypeEnum::isValueType($value, $values, $current))->toBe($expected);
    }else{
        expect(ValueTypeEnum::isValueType($value, $values))->toBe($expected);
    }
})
->with([
    ["1",[],null, ValueTypeEnum::NM],
    ["Some text",[],null, ValueTypeEnum::ST],
    ["Some text",["bla"],null, ValueTypeEnum::CE],
    ["Some text",["bla"],ValueTypeEnum::ST, ValueTypeEnum::CE],
    ["123.45",["bla"],ValueTypeEnum::ST, ValueTypeEnum::CE],
    ["Some text",["bla"],ValueTypeEnum::CE, ValueTypeEnum::CE],
    ["text",[],ValueTypeEnum::FT, ValueTypeEnum::FT]

]);
