<?php

/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:27
 */
class Config
{
    public static function get($chemin = null)
    {
        if ($chemin) {
            $config = $GLOBALS['config'];
            $chemin = explode('/', $chemin);

            foreach ($chemin as $donnees) {
                if (isset($config[$donnees])) {
                    $config = $config[$donnees];
                }
            }

            return $config;
        }

        return false;
    }
}