<?php

/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:28
 */
class Hash
{
    public static function creer($string)
    {
        return hash('sha256', $string);
    }

    public static function unique()
    {
        return self::creer(uniqid());
    }
}