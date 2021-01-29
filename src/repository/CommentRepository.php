<?php

require_once "Repository.php";
require_once "UserDetailsRepository.php";
require_once __DIR__."/../models/Comment.php";

class CommentRepository extends Repository
{
    private UserDetailsRepository $userDetailsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userDetailsRepository = new UserDetailsRepository();
    }

    public function addComment($comment){
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Europe/Warsaw'));
        $stmt = $this->database->connect()->prepare('
        INSERT INTO comments (user_id, type_id, date, message)
        VALUES (?, ?, ?, ?) RETURNING id');

        $stmt->execute([
            $comment->getUserId(),
            $comment->getTypeId(),
            $date->format('Y-m-d H:i:s'),
            $comment->getMessage()
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    }

    public function getCommentById($id){
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM comments WHERE id = :id');
        $stmt->bindParam(':id',$id, PDO::PARAM_INT);
        $stmt-> execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->commentMapper($comments)[0];
    }


    public function getComments($typeId){
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM comments WHERE type_id = :typeId ORDER BY date DESC');
        $stmt->bindParam(':typeId',$typeId, PDO::PARAM_INT);
        $stmt-> execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->commentMapper($comments);
    }

    public function commentMapper($commentsAssoc): array
    {
        $result = [];
        foreach ($commentsAssoc as $comment) {
            if($comment){
                $result[] = new Comment(
                    $comment['user_id'],
                    $comment['type_id'],
                    $comment['message'],
                    $comment['date'],
                    $comment['id'],
                    $this->userDetailsRepository->getUserDetailsByUserId($comment['user_id'])
                );
            }
        }
        return $result;
    }

    public function removeCommentById($id)
    {
        $stmt = $this->database->connect()->prepare('
        DELETE FROM comments WHERE id = :id;
        ');
        $stmt->bindParam(':id',$id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function editCommentById($message, $id)
    {
        $stmt = $this->database->connect()->prepare('
        UPDATE comments SET message = :message WHERE id = :id;
        ');
        $stmt->bindParam(':id',$id, PDO::PARAM_INT);
        $stmt->bindParam(':message',$message);
        $stmt->execute();
    }
}