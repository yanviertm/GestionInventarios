<?php


namespace App\Helpers;


class General
{
    private static $temp;

    public static function setTemp($data)
    {
        self::$temp = $data;
    }

    public static function getTemp()
    {
        return self::$temp;
    }
}
