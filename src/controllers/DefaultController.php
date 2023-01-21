<?php

require_once 'AppController.php';

class DefaultController extends AppController{

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
        $this->render('settings');
    }

    public function addEvent() {
        $this->render('addEvent');
    }

    public function addFriend() {
        $this->render('addFriend');
    }

    public function changePassword() {
        $this->render('changePassword');
    }

    public function deleteAccount() {
        $this->render('deleteAccount');
    }

    public function eventInfo() {
        $this->render('event-info');
    }
}