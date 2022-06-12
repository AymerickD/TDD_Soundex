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
        $this->assertSame("A000", $this->soundex->encode('A'));
    }

    public function testPadsWithZerosToEnsureThreeDigits()
    {
        $this->assertSame("I000", $this->soundex->encode("I"));
    }

    public function testReplacesConsonantsWithAppropriateDigits()
    {
        $this->assertSame("A200", $this->soundex->encode("Ax"));
    }

    public function testIgnoresNonAlphabetics()
    {
        $this->assertSame("A000", $this->soundex->encode("A#"));
    }

    public function testReplacesMultipleConsonantsWithDigits()
    {
        $this->assertSame("A234", $this->soundex->encode("Acdl"));
    }

    public function testLimitsLengthToFourCharacters()
    {
        $this->assertSame("4u", $this->soundex->encode("Dcdlb"));
    }
}