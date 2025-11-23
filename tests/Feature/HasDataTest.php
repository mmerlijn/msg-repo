<?php

use mmerlijn\msgRepo\Name;

it('organisation hasData', function () {
    $o = new \mmerlijn\msgRepo\Organisation();
    expect($o->hasData())->toBeFalse();
    $o = new \mmerlijn\msgRepo\Organisation(name: 'Hospital');
    expect($o->hasData())->toBeTrue();
});

it('insurance hasData', function () {
    $i = new \mmerlijn\msgRepo\Insurance();
    expect($i->hasData())->toBeFalse();
    $i = new \mmerlijn\msgRepo\Insurance(company_name: 'InsureCo');
    expect($i->hasData())->toBeTrue();
});

it('patient hasData', function () {
    $p = new \mmerlijn\msgRepo\Patient();
    expect($p->hasData())->toBeFalse();
    $p = new \mmerlijn\msgRepo\Patient(bsn: '123456789');
    expect($p->hasData())->toBeTrue();
});

it('contact hasData', function () {
    $c = new \mmerlijn\msgRepo\Contact();
    expect($c->hasData())->toBeFalse();
    $c = new \mmerlijn\msgRepo\Contact(name: new Name(name:'John Doe'));
    expect($c->hasData())->toBeTrue();
});

it('address hasData',function(){
    $a=new \mmerlijn\msgRepo\Address();
    expect($a->hasData())->toBeFalse();
    $a=new \mmerlijn\msgRepo\Address(street:'Main St');
    expect($a->hasData())->toBeTrue();
});
