<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('index', 'DefaultController');
Routing::get('login', 'DefaultController');
Routing::get('register', 'DefaultController');
Routing::get('friends', 'DefaultController');
Routing::get('map', 'DefaultController');
Routing::get('events', 'DefaultController');
Routing::get('settings', 'DefaultController');
Routing::get('addEvent', 'DefaultController');
Routing::get('addFriend', 'DefaultController');
Routing::get('changePassword', 'DefaultController');
Routing::get('deleteAccount', 'DefaultController');
Routing::get('eventInfo', 'DefaultController');
Routing::run($path);