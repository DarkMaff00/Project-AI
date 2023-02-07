<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../repository/EventRepository.php';

class EventController extends AppController
{
    private $eventRepository;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->eventRepository = new EventRepository();
        $this->userRepository = new UserRepository();
    }

    public function addEvent()
    {
        $this->checkAuthentication();
        if (!$this->isPost()) {
            return $this->render('addEvent');
        }
        $hash = $_COOKIE['user'];
        $login = $this->userRepository->getUser($hash)->getLogin();

        if ($_POST['name'] == null or $_POST['description'] == null or $_POST['mode'] == null or $_POST['event-place'] == null or $_POST['eventDate'] == null or $_POST['eventTime'] == null or $_POST['event-type'] == null or $_POST['maxNumber'] == null or $_POST['access'] == null) {
            return $this->render('addEvent', ['messages' => ['Należy wypełnić wszystkie pola']]);
        }

        $event = new Event($_POST['name'], $_POST['description'], $_POST['mode'], $_POST['event-place'], $_POST['eventDate'], $_POST['eventTime'], $_POST['event-type'], $_POST['maxNumber'], $_POST['access'], $login);
        $this->eventRepository->addEvent($event);
        return $this->render('addEvent', ['messages' => ['Pomyslnie stworzono event']]);
    }

    public function deleteEvent() {
        $this->checkAuthentication();

        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);
        $event = $this->eventRepository->getEvent(5);

        if ($event->getOrganizer() == $user->getLogin() OR $user->getRole() == 'ADMIN') {
            $this->eventRepository->deleteEvent(5);
            return $this->render('event-info', ['messages' => ['Usunieto pomyslnie']]);
        }
        return $this->render('event-info', ['messages' => ['Brak uprawnien']]);
    }

    public function addToEvent() {
        $this->checkAuthentication();
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);
        $event = $this->eventRepository->getEvent(5);
        if($event->getAccess() == 'private' AND $user->getLogin() != $event->getOrganizer()){
            return $this->render('event-info', ['messages' => ['Brak uprawnien']]);
        }
        $login = 'jan16';
        if($this->userRepository->checkIfAlreadyFriends($user->getLogin(), $login)){
            return $this->render('event-info', ['messages' => ['Nie masz takiego uzytkownika w znajomych']]);
        }
        if($this->eventRepository->checkIfAssigned(5,$login)){
            return $this->render('event-info', ['messages' => ['Ten uæytkownik jest juz w tym evencie']]);
        }
        if(!$this->eventRepository->checkUserLimit(5)){
            return $this->render('event-info', ['messages' => ['Ten event osiagnal limit uzytkownikow']]);
        }
        $this->eventRepository->addToEvent(5,$login);
        return $this->render('event-info', ['messages' => ['Uzytkownik zostal dodany do eventu']]);
    }

    public function leaveEvent() {
        $this->checkAuthentication();
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);
        $event = $this->eventRepository->getEvent(5);
        if($event->getOrganizer() == $user->getLogin()){
            return $this->render('event-info', ['messages' => ['Nie mozesz opouscic wlasnego eventu']]);
        }
        $this->eventRepository->leaveEvent(5, $user->getLogin());
        return $this->render('event-info', ['messages' => ['Nie mozesz opouscic wlasnego eventu']]);
    }
}