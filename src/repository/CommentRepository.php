<?php
require_once 'Repository.php';

class CommentRepository extends Repository
{
    public function addComment(Comment $comment)
    {
        $stmt = $this->database->connect()->prepare('
        INSERT INTO comments ( id_event, login_user, content, add_date) 
        VALUES (?,?,?,current_timestamp) 
        ');

        $stmt->execute([
            $comment->getIdEvent(),
            $comment->getLoginUser(),
            $comment->getContent()
        ]);
    }

    public function getComments(int $idEvent)
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * from comments WHERE id_event = ?
        ');
        $stmt->execute([$idEvent]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}