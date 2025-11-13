<?php

use mmerlijn\msgRepo\TestCode;

it('test can be set', function ($data, $expected) {
    $request = new \mmerlijn\msgRepo\Request();
    $request->setTest($data);
    expect($request->test->code)->toBe($expected->code)
    ->and($request->test->name)->toBe($expected->name)
        ->and($request->test->source)->toBe($expected->source);
})->with([
    [['ABC','Alpha','L'], new TestCode(code: 'ABC', name: 'Alpha', source: 'L')],
    [new TestCode(code: 'ABC', name: 'Alpha', source: 'L'),new TestCode(code: 'ABC', name: 'Alpha', source: 'L')]
]);

it('other test can be set', function ($data, $expected) {
    $request = new \mmerlijn\msgRepo\Request();
    $request->setOtherTest($data);
    expect($request->other_test->code)->toBe($expected->code)
    ->and($request->other_test->name)->toBe($expected->name)
        ->and($request->other_test->source)->toBe($expected->source);
})->with([
    [['XYZ','Xray','L'], new TestCode(code: 'XYZ', name: 'Xray', source: 'L')],
    [new TestCode(code: 'XYZ', name: 'Xray', source: 'L'),new TestCode(code: 'XYZ', name: 'Xray', source: 'L')]
]);

it('container can be set', function ($data, $expected) {
    $request = new \mmerlijn\msgRepo\Request();
    $request->setContainer($data);
    expect($request->container->code)->toBe($expected->code)
    ->and($request->container->name)->toBe($expected->name)
        ->and($request->container->source)->toBe($expected->source);
})->with([
    [['CTN1','Container1','L'], new TestCode(code: 'CTN1', name: 'Container1', source: 'L')],
    [new TestCode(code: 'CTN1', name: 'Container1', source: 'L'),new TestCode(code: 'CTN1', name: 'Container1', source: 'L')]
]);

it('can be exorted as array', function () {
    $request = new \mmerlijn\msgRepo\Request(
        test: new TestCode(code: 'TST1', name: 'Test1', source: 'L'),
        other_test: new TestCode(code: 'OTST1', name: 'OtherTest1', source: 'L'),
        container: new TestCode(code: 'CTN1', name: 'Container1', source: 'L'),
    );
    $array = $request->toArray();
    expect($array)->toHaveKey(
        'test' )
    ->and($array['test']['code'])->toBe('TST1')
    ->and($array['other_test']['name'])->toBe('OtherTest1')
    ->and($array['container']['source'])->toBe('L')
    ;
});

