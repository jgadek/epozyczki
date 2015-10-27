<?php

namespace Acme\Utils;

class Cleaner
{

    public static function String($text)
    {
        return trim($text);
    }

    public static function GetPriceLabel($price, $separator = '.')
    {
        if ($price > 1000000) {
            return preg_replace('/(\d+)(\d{3})(\d{3})/', '\\1' . $separator . '\\2' . $separator . '\\3', $price);
        }
        return preg_replace('/(\d+)(\d{3})/', '\\1' . $separator . '\\2', $price);
    }

}
