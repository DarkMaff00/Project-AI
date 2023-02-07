<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class DefaultController extends AppController{

    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function index() {
        $this->render('start');
    }

    public function events() {
        $this->render('events');
    }

    public function login() {
        $this->render('login');
    }

    public function register() {
        $this->render('register');
    }

    public function friends() {
        $this->render('friends');
    }

    public function map() {
        $this->render('map');
    }

    public function settings() {

        $this->checkAuthentication();
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);
        $this->render('settings', ['user' => $user]);
    }

    public function eventInfo() {
        $this->render('event-info');
    }

    public function logout() {
        setcookie("user", $_COOKIE['user'], time() - 7000, "/");
        if (isset($_COOKIE['user'])) {
            header("Refresh:0");
        }
        $this->index();
    }
}