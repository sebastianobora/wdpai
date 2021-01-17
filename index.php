<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('index','DefaultController');

Routing::get('user', 'UserController');

Routing::get('type', 'TypeController');
Routing::get('types','TypeController');
Routing::get('myTypes', 'TypeController');

Routing::post('login','SecurityController');
Routing::post('register', 'SecurityController');
Routing::get('logout', 'SecurityController');

Routing::get('like', 'TypeController');
Routing::get('dislike', 'TypeController');


Routing::post('addType','TypeController');
Routing::post('search', 'TypeController');

/*Routing::post('usernameExist', 'UserController');*/

Routing::run($path);
?>