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
        $stmt = $this->database->connect()->prepare('
        INSERT INTO comments (user_id, type_id, date, message, answer_to)
        VALUES (?, ?, ?, ?, ?) RETURNING id');

        $stmt->execute([
            $comment->getUserId(),
            $comment->getTypeId(),
            $date->format('Y-m-d H:i:s'),
            $comment->getMessage(),
            $comment->getAnswerTo()
        ]);
    }


    public function getComments($typeId){
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM comments WHERE type_id = :typeId');
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
}