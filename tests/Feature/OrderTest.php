<?php

use mmerlijn\msgRepo\TestCode;

it('can remove all observations', function () {
    $msg = new \mmerlijn\msgRepo\Msg(
        order: (new \mmerlijn\msgRepo\Order)->addRequest(
            new \mmerlijn\msgRepo\Request(
                test: new TestCode(code: 'TEST1'),
                observations: [
                    new \mmerlijn\msgRepo\Observation(value: 10, test: new TestCode(code: 'OBS1')),
                    new \mmerlijn\msgRepo\Observation(value: 20, test: new TestCode(code: 'OBS2')),
                ]
            )
        )->addRequest(
            new \mmerlijn\msgRepo\Request(
                test: new TestCode(code: 'TEST2'),
                observations: [
                    new \mmerlijn\msgRepo\Observation(value: 30, test: new TestCode(code: 'OBS3')),
                ]
            )
    ));
    $msg->order->removeAllObservations();
    expect(count($msg->order->requests[0]->observations))->toBe(0)
        ->and(count($msg->order->requests[1]->observations))->toBe(0);
});

it('can get all observations', function () {
    $msg = new \mmerlijn\msgRepo\Msg(
        order: (new \mmerlijn\msgRepo\Order)->addRequest(
            new \mmerlijn\msgRepo\Request(
                test: new TestCode(code: 'TEST1'),
                observations: [
                    new \mmerlijn\msgRepo\Observation(value: 10, test: new TestCode(code: 'OBS1')),
                    new \mmerlijn\msgRepo\Observation(value: 20, test: new TestCode(code: 'OBS2')),
                ]
            )
        )->addRequest(
            new \mmerlijn\msgRepo\Request(
                test: new TestCode(code: 'TEST2'),
                observations: [
                    new \mmerlijn\msgRepo\Observation(value: 30, test: new TestCode(code: 'OBS3')),
                ]
            )
    ));
    $observations = $msg->order->getAllObservations();

    expect(count($observations))->toBe(3)
        ->and($observations['OBS1'])->toBe('10')
        ->and($observations['OBS2'])->toBe('20')
        ->and($observations['OBS3'])->toBe('30');
});

it('can count requests', function () {
    $order = (new \mmerlijn\msgRepo\Order)
        ->addRequest(new \mmerlijn\msgRepo\Request(test: new TestCode(code: 'TEST1')))
        ->addRequest(new \mmerlijn\msgRepo\Request(test: new TestCode(code: 'TEST2')))
        ->addRequest(new \mmerlijn\msgRepo\Request(test: new TestCode(code: 'TEST3')));

    expect($order->countRequests())->toBe(3)
    ->and($order->hasRequests())->toBeTrue();

    $order = (new \mmerlijn\msgRepo\Order);

    expect($order->countRequests())->toBe(0)
        ->and($order->hasRequests())->toBeFalse();

});

it('can get specimen by testcode',function () {
    $order = (new \mmerlijn\msgRepo\Order)
        ->addRequest(new \mmerlijn\msgRepo\Request(
            test: new TestCode(code: 'TEST1'),
            specimens: [
                new \mmerlijn\msgRepo\Specimen(test: new TestCode(code: 'TEST1', value:'test 1'), container: new TestCode(code:'C1', value: 'Blood')),
                new \mmerlijn\msgRepo\Specimen(test: new TestCode(code: 'TEST2', value:'test 2')),
            ]
        ))
        ->addRequest(new \mmerlijn\msgRepo\Request(
            test: new TestCode(code: 'TEST2'),
            specimens: [
                new \mmerlijn\msgRepo\Specimen(test: new TestCode(code: 'TEST3', value:'test 3'), container: new TestCode(code:'C2', value: 'Blood')),
            ]
        ));

    $specimen1 = $order->getSpecimenByTestCode('TEST1');
    $specimen2 = $order->getSpecimenByTestCode('TEST2');
    $specimen3 = $order->getSpecimenByTestCode('TEST3');
    $specimen4 = $order->getSpecimenByTestCode('TEST4');

    expect($specimen1->test->code)->toBe('TEST1')
        ->and($specimen2->test->code)->toBe('TEST2') //first match
        ->and($specimen3->test->code)->toBe('TEST3')
        ->and($specimen4)->toBeNull();
});
