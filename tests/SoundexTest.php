<?php

use PHPUnit\Framework\TestCase;
use App\Entity\Soundex;

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

    public function testIgnoresNonAlphabetic()
    {
        $this->assertSame("A000", $this->soundex->encode("A#"));
    }

    public function testReplacesMultipleConsonantsWithDigits()
    {
        $this->assertSame("A234", $this->soundex->encode("Acdl"));
    }

    public function testLimitsLengthToFourCharacters()
    {
        $this->assertEquals("4", strlen($this->soundex->encode("Dcdlb")));
    }

    public function testIgnoresVowelLikeLetters()
    {
        $this->assertSame("B234", $this->soundex->encode("BaAeEiIoOuUhHyYcdl"));
    }

    public function testCombinesDuplicateEncodings()
    {
        $this->assertSame($this->soundex->encodedDigit('b'), $this->soundex->encodedDigit('f'));
        $this->assertSame($this->soundex->encodedDigit('c'), $this->soundex->encodedDigit('g'));
        $this->assertSame($this->soundex->encodedDigit('d'), $this->soundex->encodedDigit('t'));

        $this->assertSame("A123", $this->soundex->encode("Abfcgdt"));
    }

    public function testUppercaseFirstLetter()
    {
        $this->assertStringStartsWith("A", $this->soundex->encode("abcd"));
    }

    public function testIgnoresCaseWhenEncodingConsonants()
    {
        $this->assertSame($this->soundex->encode("Bcdl"), $this->soundex->encode("BCDL"));
    }

    public function testCombinesDuplicateCodesWhen2ndLetterDuplicates1st()
    {
    $this->assertSame("B230", $this->soundex->encode("Bbcd"));
    }
     
    public function testDoesNotCombineDuplicateEncodingsSeparatedByVowels()
    {
        $this->assertSame("J110", $this->soundex->encode("Jbob"));
    }

    public function testCombineDuplicateEncodingsSeparatedByHOrW()
    {
        $this->assertSame("B341", $this->soundex->encode("Bthtlf"));
    }
}
