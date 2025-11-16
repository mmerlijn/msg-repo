<?php

use mmerlijn\msgRepo\TestCode;

it('can be initialized', function ($data, $expected) {;
    $this->assertEquals($data->code, $expected['code']);
    $this->assertEquals($data->value, $expected['name']);
    $this->assertEquals($data->source, $expected['source']);

})->with([
    [new TestCode(code: "L", value: "Val", source: "AB"), ['code' => 'L', 'name' => 'Val', 'source' => 'AB']],
    [new TestCode(code: "L", value: "Val"), ['code' => 'L', 'name' => 'Val', 'source' => '']],
]);
