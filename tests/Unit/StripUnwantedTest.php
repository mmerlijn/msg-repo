<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Address;
use mmerlijn\msgRepo\Helpers\StripUnwanted;
use mmerlijn\msgRepo\tests\TestCase;

class StripUnwantedTest extends TestCase
{
    public function test_strip_names()
    {
        $string = 'Vries***';
        $this->assertSame('Vries', StripUnwanted::format($string));
        $string = 'Vries.';
        $this->assertSame('Vries', StripUnwanted::format($string));
        $string = 'Vries\\br\\';
        $this->assertSame('Vries', StripUnwanted::format($string));
        $string = 'Vries - ';
        $this->assertSame('Vries', StripUnwanted::format($string));
        $string = 'Vries*od*';
        $this->assertSame('Vries', StripUnwanted::format($string));
        $string = 'Gert Jan';
        $this->assertSame('Gert Jan', StripUnwanted::format($string));
    }

    public function test_strip_comments()
    {
        $string = 'Green Hba1c\.br\Lorem';
        $this->assertSame('Green Hba1c. Lorem', StripUnwanted::format($string, 'comment'));
    }
}