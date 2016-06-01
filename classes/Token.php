<?php

/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:28
 */
class Token
{
    public static function generer()
    {
        return Session::put(Config::get('session/token_nom'), sha1(uniqid()));
    }

    public static function check($token)
    {
        $tokenNom = Config::get('session/token_nom');
        if (Session::existe($tokenNom) && $token === Session::get($tokenNom)) {
            Session::effacer($tokenNom);

            return true;
        }

        return false;
    }
}