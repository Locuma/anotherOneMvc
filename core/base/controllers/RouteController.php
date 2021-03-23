<?php


namespace core\base\controllers;
use core\base\settings\Settings;

class RouteController
{
    static private $_instance;

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
    private function __construct()
    {
        $s = Settings::get('routes');

//        var_dump($s);


        exit();
    }

    static public function getInstance(){
        if (self::$_instance instanceof self){
            return self::$_instance;
        }
        return self::$_instance = new self();
    }

}