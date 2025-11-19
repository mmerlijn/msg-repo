<?php

use Carbon\Carbon;

it('can check date field', function (Carbon|string $date,Carbon $today, ?Carbon $expected) {
    expect(\mmerlijn\msgRepo\Helpers\PrikDatum::CheckDateField($date, $today)?->format('Y-m-d'))
        ->toBe($expected?->format('Y-m-d'));
})->with([
    ["20251208", Carbon::create(2025, 12, 7), Carbon::create(2025, 12, 8)],
    ["20251208", Carbon::create(2025, 12, 9), null],
    ["202512", Carbon::create(2025, 12, 7), null],
    ["2025", Carbon::create(2025, 6, 1), null],
    ["", Carbon::create(2025, 6, 1), null],
    ["invalid", Carbon::create(2025, 6, 1), null],
    [Carbon::create(2025,12,15), Carbon::create(2025,12,1), Carbon::create(2025,12,15)],
    ["10 mrt 2025", Carbon::create(2025,3,1), Carbon::create(2025,3,10)],
    ["10-12-2025", Carbon::create(2025,12,1), Carbon::create(2025,12,10)]

]);

it('can get prikdatum from message',function(){
    $today = Carbon::create('2025-12-09');
    $msg = new \mmerlijn\msgRepo\Msg(
        order: new \mmerlijn\msgRepo\Order(
            start_date: Carbon::create('2025-12-29')
        )
    );

    expect(\mmerlijn\msgRepo\Helpers\PrikDatum::get($msg, $today)?->format('Y-m-d'))->toBe("2025-12-29");

    $msg = new \mmerlijn\msgRepo\Msg(
        order: new \mmerlijn\msgRepo\Order(
            requests:[
                new \mmerlijn\msgRepo\Request(
                    observations:[
                        new \mmerlijn\msgRepo\Observation(
                            value: "20260115",
                            test: new \mmerlijn\msgRepo\TestCode(code:"ZZ",value:"gewenste afnamedatum")
                        )
                    ],
                )
            ]
        )
    );
    expect(\mmerlijn\msgRepo\Helpers\PrikDatum::get($msg, $today)?->format('Y-m-d'))->toBe("2026-01-15");
});

it('can set prikdatum to message',function(){
    $msg = new \mmerlijn\msgRepo\Msg(
        order: new \mmerlijn\msgRepo\Order(
            requests:[
                new \mmerlijn\msgRepo\Request(
                    observations:[]
                )
            ]
        )
    );
    \mmerlijn\msgRepo\Helpers\PrikDatum::set($msg, Carbon::create('2026-02-20'));
    expect(count($msg->order->requests))->toBe(1)
        ->and(count($msg->order->requests[0]->observations))->toBe(1)
        ->and($msg->order->requests[0]->observations[0]->test->code)->toBe("ZZ")
        ->and($msg->order->requests[0]->observations[0]->value)->toBe("20260220")
        ->and ($msg->order->start_date?->format('Y-m-d'))->toBe("2026-02-20");
});

it('can reset prikdatum from message',function(){
    $msg = new \mmerlijn\msgRepo\Msg(
        order: new \mmerlijn\msgRepo\Order(
            start_date: Carbon::create('2026-01-15'),
            requests:[
                new \mmerlijn\msgRepo\Request(
                    observations:[
                        new \mmerlijn\msgRepo\Observation(
                            value: "20260115",
                            test: new \mmerlijn\msgRepo\TestCode(code:"ZZ",value:"gewenste afnamedatum")
                        ),
                        new \mmerlijn\msgRepo\Observation(
                            value: "20260115",
                            test: new \mmerlijn\msgRepo\TestCode(code:"YY",value:"opmerking thuisprikken")
                        ),
                    ],
                )
            ]
        )
    );
    \mmerlijn\msgRepo\Helpers\PrikDatum::reset($msg);
    expect(count($msg->order->requests[0]->observations))->toBe(0)
    ->and($msg->order->start_date)->toBeNull();
});
