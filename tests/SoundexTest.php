<?php

use PHPUnit\Framework\TestCase;

class Soundex 
{
    public function encode(string $word) 
    {
        return "A";
    }
}

class SoundexTest extends TestCase 
{
    public function testRetainsSoleLetterOfOneLetterWord()
    {
        $soundex = new Soundex();
        $encoded = $soundex->encode('A');

        $this->assertSame("A", $encoded);
    }
}