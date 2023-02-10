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

    public function addComment(int $id)
    {
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $content = $decoded['content'];

            $comment = new Comment($id, $user->getLogin(), $content, date('Y/m/d H:i:s'));
            $this->commentRepository->addComment($comment);

            header('Content-type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'Comment added to the event successfully']);
        }
    }

    public
    function comments(int $id)
    {
        header('Content-type: application/json');
        http_response_code(200);
        echo json_encode($this->commentRepository->getComments($id));
    }
}