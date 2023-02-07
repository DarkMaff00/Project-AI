<?php
require_once 'Repository.php';

class CommentRepository extends Repository
{

    public function getComment(int $id) {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM comments WHERE id = :id');
        $stmt->bindParam(':id',  $id, PDO::PARAM_INT);
        $stmt->execute();
        $comment = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$comment) {
            throw new UnexpectedValueException();
        }

        return new Comment (
            $comment['id_event'],
            $comment['login_user'],
            $comment['content'],
        );
    }
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

    public function deleteComment($id)
    {
        $stmt = $this->database->connect()->prepare('
           DELETE FROM comments WHERE id = :id    
        ');
        $stmt->execute([$id]);
    }
}