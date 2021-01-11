<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('index','DefaultController');

Routing::get('types','TypeController');
Routing::get('games', 'TypeController');
Routing::get('music', 'TypeController');
Routing::get('series', 'TypeController');
Routing::get('movie', 'TypeController');
Routing::get('book', 'TypeController');
Routing::get('youtube', 'TypeController');
Routing::get('instagram', 'TypeController');

Routing::post('login','SecurityController');
Routing::post('register', 'SecurityController');
Routing::get('logout', 'SecurityController');

Routing::post('addType','TypeController');
Routing::post('search', 'TypeController');

Routing::run($path);
?>