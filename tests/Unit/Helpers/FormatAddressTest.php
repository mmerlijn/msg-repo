<?php

it('format building_nr', function (\mmerlijn\msgRepo\Address $address, \mmerlijn\msgRepo\Address $expectedAddress) {
    expect($address->building_nr)->toBe($expectedAddress->building_nr)
    ->and($address->building_addition)->toBe($expectedAddress->building_addition)
    ->and($expectedAddress->building)->toBe($address->building);
})->with([
    [new \mmerlijn\msgRepo\Address(building: " 12A "), new \mmerlijn\msgRepo\Address(building_nr: "12",building_addition: "A")],
    [new \mmerlijn\msgRepo\Address(building: "  34 B  "), new \mmerlijn\msgRepo\Address(building_nr: "34",building_addition: "B")],
    [new \mmerlijn\msgRepo\Address(building: "56"), new \mmerlijn\msgRepo\Address(building_nr: "56",building_addition: "")],
    [new \mmerlijn\msgRepo\Address(building: "  78-C "), new \mmerlijn\msgRepo\Address(building_nr: "78",building_addition: "C")],
    [new \mmerlijn\msgRepo\Address(building: "78-4"), new \mmerlijn\msgRepo\Address(building_nr: "78",building_addition: "4")],
    [new \mmerlijn\msgRepo\Address(street:"Van Wijkstraat",building_nr: "92",building_addition: 68), new \mmerlijn\msgRepo\Address(building: "92-68")],
    ]);

