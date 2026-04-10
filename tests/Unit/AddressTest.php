<?php

use mmerlijn\msgRepo\Address;

it('can set address',function(){
    $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street", building: "56 a", country: "NL");
    expect($address)
        ->street->toBe("Long Street")
    ->city->toBe("Amsterdam")
    ->building->toBe("56 a")
        ->building_nr->toBe('56')
        ->building_addition->toBe('a')
    ->country->toBe("NL")
    ->postcode->toBe("1040AB")
    ;
});

it('can set address2',function(){
    $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street", building: "56 1", country: "NL");
    expect($address)
        ->street->toBe("Long Street")
        ->city->toBe("Amsterdam")
        ->building->toBe("56-1")
        ->building_nr->toBe('56')
        ->building_addition->toBe('1')
        ->country->toBe("NL")
        ->postcode->toBe("1040AB")
    ;
});

it('can set address with street building',function() {
    $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street 4", building: "a/b", country: "NL");
    expect($address)
        ->street->toBe("Long Street")
        ->city->toBe("Amsterdam")
        ->building->toBe("4 a/b")
        ->building_nr->toBe('4')
        ->building_addition->toBe('a/b');
});
it('can set address with strange street',function() {
    $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "1e Long Street", building: "3a/b", country: "NL");
    expect($address)
        ->street->toBe("1e Long Street")
        ->city->toBe("Amsterdam")
        ->building_nr->toBe('3')
        ->building_addition->toBe('a/b');
});
it('can set building and building nr',function() {
    $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street", building: "3a/b", building_nr: "3", building_addition: "a/b", country: "NL");
    expect($address)
        ->street->toBe("Long Street")
        ->city->toBe("Amsterdam")
        ->building_nr->toBe('3')
        ->building_addition->toBe('a/b');
});

it('can set building and building nr building',function() {
    $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street", building_nr: "3", building_addition: "a/b", country: "NL");
    expect($address)
        ->building->toBe("3 a/b")
        ->city->toBe("Amsterdam")
        ->building_nr->toBe('3')
        ->building_addition->toBe('a/b')
    ->street->toBe("Long Street");
});

it('can set building from street and building',function(Address $address,string $building_nr, string $building_addition, string $building, string $city) {
    expect($address)
        ->building->toBe($building)
        ->city->toBe($city)
        ->building_nr->toBe($building_nr)
        ->building_addition->toBe($building_addition)
        ->street->toBe("Long Street");
})->with([
    [new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street", building: "107 1"),'107','1','107-1','Amsterdam'],
    [new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street", building: "107-1"),'107','1','107-1','Amsterdam'],
    [new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street", building: "107-a"),'107','a','107 a','Amsterdam'],
    [new Address(postcode: "1040 AB", city: "AMSTERDAM", street: "Long Street ", building: "56 Long Street", country: "NL"),'56','','56','Amsterdam']
]);

it('can format with only street',function(Address $address, string $street, string $building_nr, string $building_addition, string $building, string $city) {
    expect($address)
        ->building->toBe($building)
        ->city->toBe($city)
        ->building_nr->toBe($building_nr)
        ->building_addition->toBe($building_addition)
        ->street->toBe($street);
})->with([
    [new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street 4 A", country: "NL"),'Long Street','4','A','4 A','Amsterdam'],
    [new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street 4 1", country: "NL"),'Long Street','4','1','4-1','Amsterdam'],
    [new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street 4 1", country: "NL"),"Long Street",'4','1','4-1','Amsterdam']

]);
it('can strip unwanted chars',function(Address $address, string $street, string $building_nr, string $building_addition, string $building, string $city){
    expect($address)
        ->building->toBe($building)
        ->city->toBe($city)
        ->building_nr->toBe($building_nr)
        ->building_addition->toBe($building_addition)
        ->street->toBe($street);
})->with([
    [new Address(postcode: "1040 AB\E\r", city: "AMSTERDAM", street: " Long Street. ", building: " 56 A ", country: "NL"),'Long Street.','56','A','56 A','Amsterdam'],
]);
