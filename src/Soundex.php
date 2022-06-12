<?php 

namespace App;

class Soundex 
{
    const MAX_CODE_LENGTH = 4;

    const ENCODINGS = [
        'b' => '1', 'f' => '1', 'p' => '1', 'v' => '1',
        'c' => '2', 'g' => '2', 'j' => '2', 'k' => '2', 'q' => '2', 's' => '2', 'x' => '2', 'z' => '2',
        'd' => '3', 't' => '3',
        'l' => '4',
        'm' => '5', 'n' => '5',
        'r' => '6'
    ];

    public function encode(string $word) : string
    {
        return $this->zeroPad($this->head($word) . $this->encodedDigits($this->tail($word)));
    }

    private function head(string $word): string
    {
        return substr($word, 0, 1);
    }

    private function tail(string $word):string
    {
        return substr($word, 1);
    }

    private function encodedDigits(string $word): string
    {
        $encoding = "";
        foreach (str_split($word) as $letter) {
            $encoding .= $this->encodedDigit($letter);
        }

        return $encoding;
    }

    private function encodedDigit(string $letter): string
    {
        return key_exists($letter, self::ENCODINGS) ? self::ENCODINGS[$letter] : "";
    }

    private function zeroPad(string $word): string
    {
        $zerosNeeded = self::MAX_CODE_LENGTH - strlen($word);
        return $word . str_repeat('0', $zerosNeeded);
    }
}