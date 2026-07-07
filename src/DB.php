<?php

namespace Flaviosalgado\Testebasico;

class DB
{
    private static $instance;

    public static function getConn()
    {
        if (!isset(self::$instance)) {
            self::$instance = new \PDO('mysql:host=mysql;dbname=app;charset=utf8', 'app', 'secret');
        }

        return self::$instance;
    }
}