<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/TypeController.php';

class Routing {
    public static $routes; # url oraz ścieżka kontrolera

    public static function get($url, $view){
        self::$routes[$url] = $view;
    }

    public static function post($url, $view){
        self::$routes[$url] = $view;
    }

    public static function run($url){
        $action = explode("/", $url)[0];

        if(!array_key_exists($action, self::$routes)){
            die('Wrong url!');
        }

        $controller = self::$routes[$action];

        if(!isset($_COOKIE["user"]) and $action != 'login'){
            $action = 'index';
            $controller = 'DefaultController';
        }

        if($action == ''){
            $action = 'index';
        }

        if(isset($_COOKIE["user"]) and ($action == 'login' or 'index')){
            $action = 'types';
            $controller = 'TypeController';
        }

        $object = new $controller;
        $object->$action();
    }

}

?>