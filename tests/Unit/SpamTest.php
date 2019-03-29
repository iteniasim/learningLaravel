<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    public function testItChecksForInvalidKeywords()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Reply without spam.'));

        $this->expectException(\Exception::class);

        $this->assertTrue($spam->detect('this fucking peice of shit!'));
    }

    public function testItchecksForAnyKeyBeingHeldDown()
    {
        $this->expectException(\Exception::class);
        (new Spam)->detect('musiccccc');
    }
}
