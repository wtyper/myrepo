<?php
namespace App\Helper;

class StringHelper
{
    public static function endWith($string, $endString)
    {
        $len = strlen($endString);
        if ($len === 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }
}
