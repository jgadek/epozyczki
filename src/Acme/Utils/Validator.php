<?php

namespace Acme\Utils;

class Validator
{
    public static function email($text)
    {
        if(filter_var($text, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
}
