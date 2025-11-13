<?php

it('dump repository', function () {

    $msg = new \mmerlijn\msgRepo\Msg();
    $array = $msg->toArray();
    dd($array);
});
