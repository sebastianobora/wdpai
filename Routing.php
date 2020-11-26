<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/TypeController.php';

class Routing {
    public static $routes; # url oraz ścieżka kontrolera

    public static function get($url, $controller){
        self::$routes[$url] = $controller;
    }

    public static function post($url, $controller){
        self::$routes[$url] = $controller;
    }

    public static function run($url){
        $action = explode("/", $url)[0];

        if(!array_key_exists($action, self::$routes)){
            die('Wrong url!');
        }

        $controller = self::$routes[$action];
        $object = new $controller; 
        # tworzymy obiekt na podstawie stringa, tu będzie nazwa controllera

        $object->$action();
    }

}

?>