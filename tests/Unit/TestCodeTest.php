<?php

use mmerlijn\msgRepo\TestCode;

it('can be initialized', function ($data, $expected) {
    $this->assertEquals($data->code, $expected['code']);
    $this->assertEquals($data->value, $expected['value']);
    $this->assertEquals($data->source, $expected['source']);

})->with([
    [new TestCode(code: "L", value: "Val", source: "AB"), ['code' => 'L', 'value' => 'Val', 'source' => 'AB'] ],
    [new TestCode(code: "L", value: "Val"), ['code' => 'L', 'value' => 'Val', 'source' => ''] ],
]);

it('can converted object to array',function(){
   $testcode = new TestCode(code: "L", value: "Val", source: "AB");
   $a_testcode = $testcode->toArray();
   expect($a_testcode)->toBeArray()
       ->and($a_testcode['code'])->toBe("L")
       ->and($a_testcode['value'])->toBe("Val")
       ->and($a_testcode['source'])->toBe("AB");
});


it('can converted array to object',function(){
    $testcode = new TestCode(code: "L", value: "Val", source: "AB");
    $a_testcode = $testcode->toArray();
    $n_testcode = (new TestCode)->fromArray($a_testcode);
    expect($n_testcode)->toMatchObject($testcode);

});