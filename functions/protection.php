<?php
/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:30
 */

function protection($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}