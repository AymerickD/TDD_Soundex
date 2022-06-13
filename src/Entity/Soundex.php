<?php

namespace App\Entity;

use App\Tools\StringTools;

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

    const NOT_A_DIGIT = "*";

    public function encode(string $word) : string
    {
        return $this->zeroPad(StringTools::upper(StringTools::head($word)) . StringTools::tail($this->encodedDigits($word)));
    }

    private function encodedDigits(string $word): string
    {
        $encoding = "";

        $this->encodeHead($encoding, $word);
        $this->encodeTail($encoding, $word);

        return $encoding;
    }

    private function encodeHead(string &$encoding, string $word): void
    {
        $encoding .= $this->encodedDigit(substr($word, 0, 1));
    }

    private function encodeTail(string &$encoding, string $word): void
    {
        for ($i=1; $i < strlen($word); $i++) { 
            if ($this->isComplete($encoding))
                break;

            $this->encodeLetter($encoding, $word[$i], $word[$i - 1]);
        }
    }

    private function encodeLetter(string &$encoding, string $letter, string $lastLetter): void
    {
        $digit = $this->encodedDigit($letter);
            if ($digit != self::NOT_A_DIGIT && ($digit != $this->lastDigit($encoding) || $this->isVowel($lastLetter)))
                $encoding .= $this->encodedDigit($letter);
    }

    private function isVowel(string $letter): bool
    {
        return in_array($letter, ['a', 'e', 'i', 'o', 'u', 'y']);
    }

    public function encodedDigit(string $letter): string
    {
        return key_exists(StringTools::lower($letter), self::ENCODINGS) ? self::ENCODINGS[StringTools::lower($letter)] : self::NOT_A_DIGIT;
    }

    private function zeroPad(string $word): string
    {
        $zerosNeeded = self::MAX_CODE_LENGTH - strlen($word);
        return $word . str_repeat('0', $zerosNeeded);
    }

    private function isComplete(string $encoding): bool
    {
        return strlen($encoding) == self::MAX_CODE_LENGTH;
    }

    private function lastDigit(string $encoding): string
    {
        if (empty($encoding))
            return "";

        return substr($encoding, -1);
    }
}
