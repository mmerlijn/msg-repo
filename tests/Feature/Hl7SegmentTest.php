<?php

it('can store hl7 segments', function () {
    $msg = new \mmerlijn\msgRepo\Msg();
    $msg->addSegment("OBR.4","test");
    $msg->addSegment("OBR.5.1","test2");

    expect($msg->getSegment("OBR.4"))->toBe('test')
    ->and($msg->getSegment("OBR.5.1"))->toBe('test2');
});
