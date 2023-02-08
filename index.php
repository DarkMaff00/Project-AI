<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('register', 'DefaultController');
Routing::get('settings', 'DefaultController');
Routing::post('confirmRegistration', 'RegistrationController');
Routing::get('friends', 'RegistrationController');
Routing::get('logout', 'DefaultController');
Routing::post('login', 'SecurityController');
Routing::post('deleteAccount', 'RegistrationController');
Routing::post('changePassword', 'RegistrationController');
Routing::post('addFriend', 'RegistrationController');
Routing::post('addEvent', 'EventController');
Routing::get('deleteEvent', 'EventController');
Routing::get('events', 'EventController');
Routing::get('addToEvent', 'EventController');
Routing::post('addComment', 'CommentController');
Routing::get('deleteComment', 'CommentController');
Routing::get('eventInfo','CommentController');
Routing::run($path);