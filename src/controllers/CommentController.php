<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../repository/CommentRepository.php';

class CommentController extends AppController
{
    private $commentRepository;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->commentRepository = new CommentRepository();
        $this->userRepository = new UserRepository();
    }

    public function addComment()
    {
        $this->checkAuthentication();
        if (!$this->isPost()) {
            return $this->render('event-info');
        }
        $hash = $_COOKIE['user'];
        $login = $this->userRepository->getUser($hash)->getLogin();
        $comment = new Comment(5, $login, $_POST['content']);
        $this->commentRepository->addComment($comment);
        return $this->render('event-info', ['messages' => ['Komentarz zostal dodany']]);
    }

    public function deleteComment()
    {
        $this->checkAuthentication();
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);
        $comment = $this->commentRepository->getComment(1);
        if ($comment->getLoginUser() == $user->getLogin() or $user->getRole() == 'ADMIN') {
            $this->commentRepository->deleteComment(1);
            return $this->render('event-info', ['messages' => ['komentarz Usunieto pomyslnie']]);
        }
        return $this->render('event-info', ['messages' => ['Brak uprawnien']]);
    }
}