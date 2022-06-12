<?php

use PHPUnit\Framework\TestCase;
use App\Soundex;

class SoundexTest extends TestCase 
{
    protected $soundex;

    protected function setUp(): void
    {
        $this->soundex = new Soundex();
    }

    public function testRetainsSoleLetterOfOneLetterWord()
    {
        $encoded = $this->soundex->encode('A');

        $this->assertSame("A000", $encoded);
    }

    public function testPadsWithZerosToEnsureThreeDigits()
    {
        $encoded = $this->soundex->encode("I");

        $this->assertSame("I000", $encoded);
    }
}