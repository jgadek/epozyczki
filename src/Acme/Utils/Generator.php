<?php

namespace Acme\Utils;

class Generator
{
    public static function GetIdNumbers()
    {
        $key = (int) (microtime() + floor(rand()*10000));
        return substr($key, 0, 9);
    }
}
