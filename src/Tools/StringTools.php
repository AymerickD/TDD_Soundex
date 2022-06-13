<?php 

namespace App\Tools;

class StringTools 
{
    public static function head(string $word): string
    {
        return substr($word, 0, 1);
    }

    public static function tail(string $word):string
    {
        return substr($word, 1);
    }

    public static function upper(string $string): string
    {
        return strtoupper($string);
    }

    public static function lower(string $string): string
    {
        return strtolower($string);
    }
}