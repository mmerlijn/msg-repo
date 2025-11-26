<?php

it('can show labels', function () {

    $labels = \mmerlijn\msgRepo\Enums\YesNoEnum::labels();
    /*
        [
          "Y" => "Ja"
          "N" => "Nee"
          "_" => "Onbekend"
        ]
     * */
    expect($labels)->toBeArray()
        ->and(count($labels))->toBe(3)
        ->and($labels['Y'])->toBe('Ja')
        ->and($labels['N'])->toBe('Nee')
        ->and($labels['_'])->toBe('Onbekend');
});

it('can set database array', function () {
    $db = \mmerlijn\msgRepo\Enums\YesNoEnum::database();
    /*
            [
              "Y" => "Y"
              "N" => "N"
              "_" => "_"
            ]

     * */
    expect($db)->toBeArray()
        ->and(count($db))->toBe(3)
        ->and($db['Y'])->toBe('Y')
        ->and($db['N'])->toBe('Y')
        ->and($db['_'])->toBe('_');
});

it('can get keys',function(){
   $k = \mmerlijn\msgRepo\Enums\YesNoEnum::keys();
    expect($k)->toBeArray()
        ->and(count($k))->toBe(3)
        ->and(in_array('YES',$k))->toBeTrue()
        ->and(in_array('NO',$k))->toBeTrue()
        ->and(in_array('_',$k))->toBeTrue();
});

it('can get values',function(){
    $k = \mmerlijn\msgRepo\Enums\YesNoEnum::values();
    expect($k)->toBeArray()
        ->and(count($k))->toBe(3)
        ->and(in_array('Y',$k))->toBeTrue()
        ->and(in_array('N',$k))->toBeTrue()
        ->and(in_array('_',$k))->toBeTrue();
});