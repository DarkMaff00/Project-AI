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

    public function register() {
        if (isset($_COOKIE['user'])) {
            $url = "htp://$_SERVER[HTTP_HOST]";
            HEADER("Location: {$url}/");
        }
        $this->render('register');
    }

    public function settings() {

        $this->checkAuthentication();
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);
        $this->render('settings', ['user' => $user]);
    }

    public function logout() {
        setcookie("user", $_COOKIE['user'], time() - 7000, "/");
        if (isset($_COOKIE['user'])) {
            header("Refresh:0");
        }
        header("Refresh:0, http://$_SERVER[HTTP_HOST]/");
    }
}