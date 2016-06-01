<?php

/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:27
 */
class Cookie
{
    public static function existe($nom)
    {
        return (isset($_COOKIE[$nom])) ? true : false;
    }

    public static function get($nom)
    {
        return $_COOKIE[$nom];
    }

    public static function put($nom, $valeur, $expiration)
    {
        if (setcookie($nom, $valeur, time() + $expiration, null, null, false, true)) {
            return true;
        }

        return false;
    }

    public static function effacer($nom)
    {
        self::put($nom, '', time() - 1);
    }
}