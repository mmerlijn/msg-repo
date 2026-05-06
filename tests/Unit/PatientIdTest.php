<?php
it('sets BSN first', function () {
    $patient = new \mmerlijn\msgRepo\Patient();
    $patient->addId(new \mmerlijn\msgRepo\Id(id:"ZD1234",authority: 'ZorgDomein',code:"VN"));
    $patient->addId(new \mmerlijn\msgRepo\Id(id:"100",authority: 'SALT',code:'VN'));
    $patient->addId(new \mmerlijn\msgRepo\Id(id:"123456782",authority: 'NLMINBIZA',type:'bsn'));
    expect($patient->ids[0]->authority)->toBe("NLMINBIZA");
    //expect($patient->ids[1]->authority)->toBe('ZorgDomein');
    expect($patient->ids[2]->authority)->toBe('SALT');
});

it('can set Salt Id first', function () {
    $patient = new \mmerlijn\msgRepo\Patient();
    $patient->addId(new \mmerlijn\msgRepo\Id(id:"123456782",authority: 'NLMINBIZA',type:'bsn'));
    $patient->addId(new \mmerlijn\msgRepo\Id(id:"ZD1234",authority: 'ZorgDomein',code:"VN"));
    $patient->addId(new \mmerlijn\msgRepo\Id(id:"100",authority: 'SALT',code:'VN'));
    $patient->setSaltIdFirst();
    expect($patient->ids)->toHaveCount(3);
    expect($patient->ids[0]->authority)->toBe("SALT");
    expect($patient->ids[1]->authority)->toBe('NLMINBIZA');
    expect($patient->ids[2]->authority)->toBe('ZorgDomein');
});


