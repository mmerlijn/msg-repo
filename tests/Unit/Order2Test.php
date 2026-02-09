<?php

use mmerlijn\msgRepo\Order;
use mmerlijn\msgRepo\TestCode;

it('filter admitReason from testcodes', function () {
    $order = new Order(admit_reason: new TestCode(code: 'ABC', value: 'test'));
    $order->addRequest(new \mmerlijn\msgRepo\Request(test: new TestCode(code: 'ABC', value: 'test2'),observations: [new \mmerlijn\msgRepo\Observation(test: new TestCode(code:'OBS', value: 'obs'))]));
    $order->addRequest(new \mmerlijn\msgRepo\Request(test: new TestCode(code: 'DEF', value: 'test3')));
    $order->filterAdmitReasonFromTestCodes();
    expect($order->requests[0]->test->code)->toBe('DEF')
    ->and(count($order->requests))->toBe(1)
    ->and($order->requests[0]->observations[0]->test->code)->toBe('OBS');
});
