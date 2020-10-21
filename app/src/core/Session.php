<?php


namespace App\core;


class Session
{
    static bool $isAdmin;

    static function isAdmin()
    {
        if (Session::isUserLogged() && $_SESSION['admin']) {
            return true;
        }
    }

    static function isUserLogged()
    {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }
}