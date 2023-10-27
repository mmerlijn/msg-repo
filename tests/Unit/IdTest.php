<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Id;

class IdTest extends \mmerlijn\msgRepo\tests\TestCase
{
    public function test_id_setter()
    {
        $id = new Id(id: "123456782", authority: "NLMINBIZA");
        $this->assertSame('bsn', $id->type);
        $this->assertSame("NNNLD", $id->code);
        $this->assertArrayHasKey('id', $id->toArray());
    }

    public function test_compact()
    {
        $id = new Id(id: "123456782");
        $this->assertIsArray($id->toArray(true));
        $this->assertArrayHasKey('id', $id->toArray(true));
        $this->assertArrayNotHasKey('authority', $id->toArray(true));
    }
}