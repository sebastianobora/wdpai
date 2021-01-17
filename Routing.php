<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/TypeController.php';
require_once 'src/controllers/UserController.php';
require_once 'src/repository/UserRepository.php';
require_once 'src/repository/UserDetailsRepository.php';
class Routing {
    public static $routes; # url oraz ścieżka kontrolera

    public static function get($url, $view){
        self::$routes[$url] = $view;
    }

    public static function post($url, $view){
        self::$routes[$url] = $view;
    }

    public static function run($url){
        $urlParts = explode("/", $url);
        $action = $urlParts[0];

        if(!array_key_exists($action, self::$routes)){
            die('Wrong url!');
        }

        $controller = self::$routes[$action];

        if(!isset($_COOKIE["user"]) and $action != 'login' and $action != 'register'){
                $action = 'index';
                $controller = 'DefaultController';
        }

        if($action == ''){
            $action = 'index';
        }

        if(isset($_COOKIE["user"]) and ($action == 'login' or $action == 'index' or $action == 'register')){
            $userRepository = new UserRepository();
            if(!$userRepository->getUserByCookie($_COOKIE["user"])){
                $action = 'index';
                $controller = 'DefaultController';
            }else{
                $action = 'types';
                $controller = 'TypeController';
            }
        }

        $arg = $urlParts[1] ?? '';

        if($action == 'types' and $arg and !in_array($arg, Type::$categories)){
            die('No such category! Wrong url!');
        }

        $typeRepository = new TypeRepository();
        if($action == 'type' and $arg and !$typeRepository->getTypeById($arg)){
            die('No such type! Wrong url!');
        }

        $userDetailsRepository = new UserDetailsRepository();
        if($action == 'user' and $arg and !$userDetailsRepository->getUserDetailsByUsername($arg)){
            die('No such user! Wrong url!');
        }

        if(($action == 'type' or $action == 'user') and !$arg){
            die('Wrong url');
        }

        $object = new $controller;
        $object->$action($arg);
    }
}
?>