<?php
/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:31
 */
require_once 'config/init.php';

$user = new User();
$user->logout();

Redirect::to('index.php');