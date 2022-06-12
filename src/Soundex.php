<?php 

namespace App;

class Soundex 
{
    public function encode(string $word) : string
    {
        return $this->zeroPad($word);;
    }

    private function zeroPad(string $word): string
    {
        return $word . "000";
    }
}