<?php

/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:28
 */
class Session
{
    public static function existe($nom)
    {
        return (isset($_SESSION[$nom])) ? true : false;
    }

    public static function put($nom, $valeur)
    {
        return $_SESSION[$nom] = $valeur;
    }

    public static function get($nom)
    {
        return $_SESSION[$nom];
    }

    public static function effacer($nom)
    {
        if (self::existe($nom)) {
            unset($_SESSION[$nom]);
        }
    }

    public static function flash($nom, $string = '')
    {
        if (self::existe($nom)) {
            $session = self::get($nom);
            self::effacer($nom);
            return $session;
        } else {
            self::put($nom, $string);
        }
    }

}