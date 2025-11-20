<?php

use mmerlijn\msgRepo\Address;
use mmerlijn\msgRepo\Enums\ObservationTestCodeEnum;
use mmerlijn\msgRepo\Msg;
use mmerlijn\msgRepo\Observation;
use mmerlijn\msgRepo\TestCode;

it('can set ObservationData', function (ObservationTestCodeEnum $code, mixed $value, mixed $expected) {
    $msg = new \mmerlijn\msgRepo\Msg(
        order: new \mmerlijn\msgRepo\Order(
            requests: [
                new \mmerlijn\msgRepo\Request()
            ]
        )
    );
    \mmerlijn\msgRepo\Helpers\ObservationData::set($msg, $code,$value);
    expect($msg->order->requests[0]->observations[0]->test->code)->toBe($code->value)
        ->and($msg->order->requests[0]->observations[0]->value)->toBe($expected);
})->with([
 [ObservationTestCodeEnum::YY, "Test", "Test"],
    [ObservationTestCodeEnum::ZZ, "20250809", "20250809"],
    [ObservationTestCodeEnum::ONBZD, "Hallo", "Hallo"],
    [ObservationTestCodeEnum::COVIDSYM, "true", "true"],
    [ObservationTestCodeEnum::HOME_VISIT_ADDRESS, new Address(postcode: "1040AA",city: "Adam",street: "Straat",building: "4 a"), "Straat, 4 a, 1040AA, Adam"],
]);

it('can get observationData',function(Observation $observation, ObservationTestCodeEnum $code, mixed $expected){
   $msg = new \mmerlijn\msgRepo\Msg(
        order: new \mmerlijn\msgRepo\Order(
            requests: [
                new \mmerlijn\msgRepo\Request(
                    observations: [
                        $observation
                    ]
                )
            ]
        )
    );
    $data = \mmerlijn\msgRepo\Helpers\ObservationData::get($msg,$code);
    if(is_string($expected)){
        expect($data)->toBe($expected);
    }else{
        expect($data)->toMatchObject($expected);
    }

})->with([
    [fn()=> new Observation(
        value: "Test",
        test: new TestCode(code: "YY",value: "opmerking thuisprikken",source: "99zdl")
    ), ObservationTestCodeEnum::YY, "Test"],
    [fn()=> new Observation(
        value: "20250809",
        test: new TestCode(code: "ZZ",value: "gewenste afnamedatum",source: "99zdl")
    ), ObservationTestCodeEnum::ZZ, "20250809"],
    [fn()=> new Observation(
        value: "Hallo",
        test: new TestCode(code: "ONBZD",value: "Onderzoek",source: "99zdl")
    ), ObservationTestCodeEnum::ONBZD, "Hallo"],
    [fn()=> new Observation(
        value: "true",
        test: new TestCode(code: "COVIDSYM",value: "Covid-19 verdacht",source: "99zdl")
    ), ObservationTestCodeEnum::COVIDSYM, "true"],
    [fn()=> new Observation(
        value: "Straat, 4a, 1040AA, Adam",
        test: new TestCode(code: "HOME_VISIT_ADDRESS",value: "Thuisafname adres",source: "99zdl")
    ), ObservationTestCodeEnum::HOME_VISIT_ADDRESS, new Address(postcode: "1040AA",city: "Adam",street: "Straat",building: "4 a")]
]);
