<?php
/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 24/05/2016
 * Time: 20:27
 */

function diffDate($timeTokenUser)
{
    $aujourdhui = new DateTime("now", new DateTimezone("Europe/Paris"));
    $token = new DateTime($timeTokenUser, new DateTimezone("Europe/Paris"));
    $temps_24h = new DateInterval('P1D');

    if ($aujourdhui->sub($temps_24h) < $token) {
        return true;
    } else {
        return false;
    }

}