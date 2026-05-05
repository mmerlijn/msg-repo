<?php

use mmerlijn\msgRepo\TestCode;

it('can add observations', function () {
    $request = new \mmerlijn\msgRepo\Request(test: new TestCode(code:'abc',value:'def'));
    $request->addObservation(new \mmerlijn\msgRepo\Observation(
        type: 'NM',
        value: 123,
        test: new TestCode(code:'ghi',value:'jkl'),
        units: 'mmHg'
    ));
    //same observation should not be added
    $request->addObservation(new \mmerlijn\msgRepo\Observation(
        type: 'NM',
        value: 123,
        test: new TestCode(code:'ghi',value:'jkl'),
        units: 'mmHg'
    ));
    expect($request->observations)->toHaveCount(1);

    //empty observation should be added
    $request->addObservation(new \mmerlijn\msgRepo\Observation(
        type: 'NM',
        value: 123,
        test: new TestCode(value:'jkl'),
        units: 'mmHg',
        values: [new TestCode(code:'ghi',value:'jkl')]
    ));
    expect($request->observations)->toHaveCount(2);

    //same empty observation should not be added
    $request->addObservation(new \mmerlijn\msgRepo\Observation(
        type: 'NM',
        value: 123,
        test: new TestCode(value:'jkl'),
        units: 'mmHg',
        values: [new TestCode(code:'ghi',value:'jkl')]
    ));
    expect($request->observations)->toHaveCount(2);

    //empty observation with different testcode-value should be added
    $request->addObservation(new \mmerlijn\msgRepo\Observation(
        type: 'NM',
        value: 123,
        test: new TestCode(value:'pno'),
        units: 'mmHg',
        values: [new TestCode(code:'ghi',value:'jkl')]
    ));
    expect($request->observations)->toHaveCount(3);
});
