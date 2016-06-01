<?php
/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:29
 */

session_start();

$GLOBALS['config'] = [
    'mysql'    => [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'mysh3ll',
        'db'       => 'cahierTxt'
    ],
    'remember' => [
        'cookie_nom'        => 'hash',
        'cookie_expiration' => 86400
    ],
    'session'  => [
        'session_nom' => 'user',
        'token_nom'   => 'tokenUser'
    ],
    'message'  => [
        'erreurSaisie'    => false,
        'erreurInsertion' => false,
        'erreurLogin' => false,
        'erreur' => false
    ],
    'env'      => 'dev'
];

spl_autoload_register(function ($class) {
    require_once 'classes/' . $class . '.php';
});

require_once 'functions/protection.php';
require_once 'functions/diffDate.php';

if (Cookie::existe(Config::get('remember/cookie_nom')) && !Session::existe(Config::get('session/session_nom'))) {
    $hash = Cookie::get((Config::get('remember/cookie_nom')));
    $hashCheck = DB::getInstance()->get('Utilisateur', ['tokenUser', '=', $hash] );

    if ($hashCheck->count()) {
        $user = new User($hashCheck->premierResultat()->idUser);
        $user->login();
    }
}