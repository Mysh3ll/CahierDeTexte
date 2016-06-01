<?php

/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:28
 */
class Redirect
{
    private $_message = null;
    public static function to($location = null)
    {
        if ($location) {
            if (is_numeric($location)) {
                switch ($location) {
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        include 'includes/erreurs/404.php';
                        exit();
                    break;
                }
            }
            header('Location:' . $location);
            exit();
        }
    }

    public function setMessage($string)
    {
        $this->_message = $string;
    }

    public function getMessage() {
        return $this->_message;
    }
}