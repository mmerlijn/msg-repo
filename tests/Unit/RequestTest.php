<?php

use mmerlijn\msgRepo\TestCode;

it('test can be set', function ($data, $expected) {
    $request = new \mmerlijn\msgRepo\Request();
    $request->setTest($data);
    expect($request->test->code)->toBe($expected->code)
    ->and($request->test->value)->toBe($expected->value)
        ->and($request->test->source)->toBe($expected->source);
})->with([
    [['ABC','Alpha','L'], new TestCode(code: 'ABC', value: 'Alpha', source: 'L')],
    [new TestCode(code: 'ABC', value: 'Alpha', source: 'L'),new TestCode(code: 'ABC', value: 'Alpha', source: 'L')]
]);

it('other test can be set', function ($data, $expected) {
    $request = new \mmerlijn\msgRepo\Request();
    $request->setOtherTest($data);
    expect($request->other_test->code)->toBe($expected->code)
    ->and($request->other_test->value)->toBe($expected->value)
        ->and($request->other_test->source)->toBe($expected->source);
})->with([
    [['XYZ','Xray','L'], new TestCode(code: 'XYZ', value: 'Xray', source: 'L')],
    [new TestCode(code: 'XYZ', value: 'Xray', source: 'L'),new TestCode(code: 'XYZ', value: 'Xray', source: 'L')]
]);

it('Specimen can be set', function ($data, $expected) {
    $request = new \mmerlijn\msgRepo\Request();
    $request->addSpecimen($data);
    expect($request->specimens[0]->test->code)->toBe($expected->code)
    ->and($request->specimens[0]->test->value)->toBe($expected->value)
        ->and($request->specimens[0]->test->source)->toBe($expected->source);
})->with([
    [new \mmerlijn\msgRepo\Specimen(test:['CTN1','Container1','L']), new TestCode(code: 'CTN1', value: 'Container1', source: 'L')],
    [new \mmerlijn\msgRepo\Specimen(test: new TestCode(code: 'CTN1', value: 'Container1', source: 'L')),new TestCode(code: 'CTN1', value: 'Container1', source: 'L')]
]);

it('can be exported as array', function () {
    $request = new \mmerlijn\msgRepo\Request(
        test: new TestCode(code: 'TST1', value: 'Test1', source: 'L'),
        other_test: new TestCode(code: 'OTST1', value: 'OtherTest1', source: 'L'),
        observations:  [new \mmerlijn\msgRepo\Observation(test:new TestCode(code: 'CTN1', value: 'Container1', source: 'L'))],
    );
    $array = $request->toArray();
    expect($array)->toHaveKey(
        'test' )
    ->and($array['test']['code'])->toBe('TST1')
    ->and($array['other_test']['value'])->toBe('OtherTest1')
    ->and($array['observations'][0]['test']['source'])->toBe('L')
    ;
});

