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

        if ($_POST['name'] == null or $_POST['description'] == null or $_POST['event-place'] == null or $_POST['eventDate'] == null or $_POST['eventTime'] == null or $_POST['maxNumber'] == null or $_POST['access'] == null) {
            return $this->render('addEvent', ['messages' => ['Należy wypełnić wszystkie pola']]);
        }

        $event = new Event($_POST['name'], $_POST['description'], $_POST['event-place'], $_POST['eventDate'], $_POST['eventTime'], $_POST['event-type'], $_POST['maxNumber'], $_POST['access'], $login);
        $this->eventRepository->addEvent($event);
        header("Refresh:0, http://$_SERVER[HTTP_HOST]/events");
    }

    public function deleteEvent(int $id)
    {
        $this->checkAuthentication();
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);
        $event = $this->eventRepository->getEvent($id);

        if ($event->getOrganizer() == $user->getLogin() || $user->getRole() == 'ADMIN') {
            $this->eventRepository->deleteEvent($id);
            header('Content-type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'Event deleted successfully']);
            return;
        }

        header('Content-type: application/json');
        http_response_code(400);
        echo json_encode(['error' => 'You do not have the required permissions to delete this event']);
    }

    public function addToEvent(int $id)
    {
        $this->checkAuthentication();
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);

        $event = $this->eventRepository->getEvent($id);


        if ($event->getAccess() === 'private' && $user->getLogin() !== $event->getOrganizer()) {
            header('Content-type: application/json');
            http_response_code(401);
            echo json_encode(['error' => 'Not authorized']);
            return;
        }

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $friendLogin = $decoded['login-friend'];

            if($this->userRepository->getUser($friendLogin) == null) {
                header('Content-type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'This user does not exist']);
                return;
            }

            if ($this->userRepository->checkIfAlreadyFriends($user->getLogin(), $friendLogin)) {
                header('Content-type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'This user is not in your friends list']);
                return;
            }

            if ($this->eventRepository->checkIfAssigned($id, $friendLogin)) {
                header('Content-type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'This user is already in this event']);
                return;
            }

            if (!$this->eventRepository->checkUserLimit($id)) {
                header('Content-type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'This event has reached the user limit']);
                return;
            }

            $this->eventRepository->addToEvent($id, $friendLogin);

            header('Content-type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'User added to the event successfully']);
        }
    }

    public function leaveEvent(int $id)
    {
        $this->checkAuthentication();
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);
        $event = $this->eventRepository->getEvent($id);
        if ($event->getOrganizer() == $user->getLogin()) {
            header('Content-type: application/json');
            http_response_code(400);
            echo json_encode(['error' => 'You cannot leave your own event']);
            return;
        }

        $this->eventRepository->leaveEvent($id, $user->getLogin());
        header('Content-type: application/json');
        http_response_code(200);
        echo json_encode(['message' => 'Event left successfully']);
    }

    public function events()
    {
        $this->checkAuthentication();
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);
        $events = $this->eventRepository->getEvents($user->getLogin(), $user->getRole());
        $members = [];
        foreach ($events as $event) {
            $members[$event->getId()] = $this->eventRepository->numberOfParticipants($event->getId());
        }
        $this->render('events', ['events' => $events, 'members' => $members]);
    }

    public function search()
    {
        $this->checkAuthentication();
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->eventRepository->getEventByTitle($user->getLogin(), $user->getRole(), $decoded['search']));
        }
    }

    public function eventInfo(int $id)
    {
        $this->checkAuthentication();
        $event = $this->eventRepository->getEvent($id);
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);
        if(!$this->eventRepository->checkIfAssigned($id, $user->getLogin()) and ($event->getOrganizer() != $user->getLogin()) and ($user->getRole() != 'ADMIN')){
            header("Refresh:0, http://$_SERVER[HTTP_HOST]/events");
        }
        $member = $this->eventRepository->numberOfParticipants($id);
        $this->render('event-info', ['event' => $event, 'member' => $member]);
    }
}