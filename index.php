<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('index','DefaultController');

Routing::get('user', 'UserController');
Routing::post('editUser', 'UserController');
Routing::post('deleteUser', 'UserController');

Routing::get('type', 'TypeController');
Routing::get('types','TypeController');
Routing::get('userTypes', 'TypeController');
Routing::get('favoriteTypes', 'TypeController');

Routing::post('login','SecurityController');
Routing::post('register', 'SecurityController');
Routing::get('logout', 'SecurityController');

Routing::post('like', 'TypeController');

Routing::post('addType','TypeController');
Routing::post('editType','TypeController');
Routing::post('deleteType', 'TypeController');
Routing::post('search', 'TypeController');

Routing::post('addComment', 'CommentController');
Routing::post('removeComment', 'CommentController');
Routing::post('editComment', 'CommentController');

Routing::run($path);
?>