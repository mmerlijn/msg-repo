<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Id;
use mmerlijn\msgRepo\Ids;
use mmerlijn\msgRepo\tests\TestCase;

class IdsTest extends TestCase
{
    public function test_ids_setter()
    {

        $ids = new Ids();
        $ids->set(new Id(id: "12312312", type: 'lbs', authority: 'SALT'))
            ->set(new Id(id: '999999999', type: 'bsn'));
        $this->assertSame("NLMINBIZA", $ids->ids[1]->authority);
        $this->assertSame("12312312", $ids->ids[0]->id);
        $this->assertIsArray($ids->toArray());
    }
}