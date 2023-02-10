<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class RegistrationController extends AppController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function confirmRegistration()
    {
        if(!$this->isPost()) {
            return $this->render('register');
        }
        if ($_POST['login'] == null or $_POST['email'] == null or $_POST['firstname'] == null or $_POST['surname'] == null or $_POST['country'] == null or $_POST['city'] == null)
            return $this->render('register', ['messages' => ['Należy wypełnić wszystkie pola']]);

        $email = $_POST['email'];
        $user = null;
        try {
            $user = $this->userRepository->getUser(md5($email));
        } catch (UnexpectedValueException $e) {
        }

        if ($user != null) {
            return $this->render('register', ['messages' => ['Użytkownik z tym adresem email istnieje']]);
        }

        $login = $_POST['login'];
        $user = null;
        try {
            $user = $this->userRepository->getUser($login);
        } catch (UnexpectedValueException $e) {
        }

        if ($user != null) {
            return $this->render('register', ['messages' => ['Użytkownik z tym loginem istnieje']]);
        }

        $newUser = new User($_POST['email'], $_POST['login'], password_hash($_POST['password'], PASSWORD_BCRYPT), $_POST['firstname'], $_POST['surname'], $_POST['country'], $_POST['city']);
        $this->userRepository->addUser($newUser);
        setcookie("user", md5($_POST['email']), time() + (3600 * 5), "/");
        header("Refresh:0, http://$_SERVER[HTTP_HOST]/");
    }

    public function deleteAccount()
    {
        $this->checkAuthentication();
        if (!$this->isPost()) {
            return $this->render('deleteAccount');
        }
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);

        $password = $_POST["password"];

        if (!password_verify($password, $user->getPassword())) {
            return $this->render('deleteAccount', ['messages' => ['Wrong password']]);
        }
        $this->userRepository->deleteUser($user->getLogin());
        setcookie("user", $_COOKIE['user'], time() - 3600, "/");
        if (isset($_COOKIE['user'])) {
            header("Refresh:0");
        }
        header("Refresh:0, http://$_SERVER[HTTP_HOST]/");
    }

    public function changePassword()
    {
        $this->checkAuthentication();
        if (!$this->isPost()) {
            return $this->render('changePassword');
        }
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);

        $password = $_POST["password"];

        if (!password_verify($password, $user->getPassword())) {
            return $this->render('changePassword', ['messages' => ['Wrong password']]);
        }

        if ($_POST['new-password'] != $_POST['new-password-again']) {
            return $this->render('changePassword', ['messages' => ['Błędnie powtórzono hasło']]);
        }

        $this->userRepository->changePassword($user->getLogin(), password_hash($_POST['new-password'], PASSWORD_BCRYPT));
        header("Refresh:0, http://$_SERVER[HTTP_HOST]/");
    }

    public function addFriend()
    {
        $this->checkAuthentication();
        if (!$this->isPost()) {
            return $this->render('addFriend');
        }
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);

        $login = $_POST["login"];

        if( $user->getLogin() == $login){
            return $this->render('addFriend', ['messages' => ['Nie mozesz dodac siebie do znajomych']]);
        }
        if ($this->userRepository->checkIfLoginExists($login)) {
            return $this->render('addFriend', ['messages' => ['Uzytkownik nie istnieje']]);
        }

        if (!$this->userRepository->checkIfAlreadyFriends($user->getLogin(), $login)) {
            return $this->render('addFriend', ['messages' => ['Juz jestescie przyjaciolmi']]);
        }

        $this->userRepository->addFriend($user->getLogin(), $login);
        header("Refresh:0, http://$_SERVER[HTTP_HOST]/friends");
    }

    public function friends() {
        $this->checkAuthentication();
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);
        $friends = $this->userRepository->getFriends($user->getLogin(),$user->getRole());
        $this->render('friends', ['friends' => $friends]);
    }
}