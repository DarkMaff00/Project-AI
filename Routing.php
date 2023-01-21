<?php

require_once 'src/controllers/DefaultCOntroller.php';

class Routing {
    public static $routers;

    public static function get($url, $controller) {
        self::$routers[$url] = $controller;
    }

    public static function run($url) {
        $action = explode("/", $url)[0];

        if(!array_key_exists($action, self::$routers)) {
            die("Wrong url!");
        }

        $controller = self::$routers[$action];
        $object = new $controller;

        $object->$action();
    }
}