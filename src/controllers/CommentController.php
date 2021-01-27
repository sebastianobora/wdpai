<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Comment.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/CommentRepository.php';

class CommentController extends AppController
{
    private $userRepository;
    private $commentRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->commentRepository = new CommentRepository();
    }


    public function addComment()
    {
        $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $userId = $this->userRepository->getUserId();
            $comment = new Comment($userId, $decoded['typeId'], $decoded['message']);
            $commentId = $this->commentRepository->addComment($comment);

            header('Content-Type: application/json');
            http_response_code(200);

            $newComment = $this->commentRepository->getCommentById($commentId);

            echo json_encode(
                [
                    'id' => $newComment->getId(),
                    'userId' => $newComment->getUserId(),
                    'typeId' => $newComment->getTypeId(),
                    'message' => $newComment->getMessage(),
                    'date' => $newComment->getDate(),
                    'avatar' => $newComment->getUserDetails()->getImage(),
                    'username' => $newComment->getUserDetails()->getUsername()
                ]);
        }
    }

    public function removeComment()
    {
        $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $userId = $this->userRepository->getUserId();
            $comment = $this->commentRepository->getCommentById($decoded['id']);

            if ($comment->getUserId() == $userId) {
                $this->commentRepository->removeCommentById($decoded['id']);
            }
            header('Content-Type: application/json');
            http_response_code(200);
        }
    }

    public function editComment()
    {
        $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $userId = $this->userRepository->getUserId();
            $comment = $this->commentRepository->getCommentById($decoded['id']);

            if ($comment->getUserId() == $userId) {
                $this->commentRepository->editCommentById($decoded['message'], $decoded['id']);
            }
            header('Content-Type: application/json');
            http_response_code(200);
        }
    }
}