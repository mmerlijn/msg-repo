<?php

it('dump repository', function () {

    $msg = new \mmerlijn\msgRepo\Msg();
    $msg->order->addRequest(new \mmerlijn\msgRepo\Request(
        test: new \mmerlijn\msgRepo\TestCode(code: '1234', value: 'Testnaam', source: 'L'),
        priority: false,
        observations: [new \mmerlijn\msgRepo\Observation(test: new \mmerlijn\msgRepo\TestCode(code: '5678', value: 'Observatiewaarde'))],

    ));
    $array = $msg->toArray();
    dd($array);
})->skip();
