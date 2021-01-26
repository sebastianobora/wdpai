<?php


class Comment
{
    private $userId;
    private $userDetails;
    private $typeId;
    private $message;
    private $date;
    private $answerTo;
    private $id;
    
    public function __construct($userId, $typeId, $message, $date = null, $id = null, $userDetails = null, $answerTo = null)
    {
        $this->userId = $userId;
        $this->userDetails = $userDetails;
        $this->typeId = $typeId;
        $this->message = $message;
        $this->date = $date;
        $this->answerTo = $answerTo;
        $this->id = $id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getTypeId()
    {
        return $this->typeId;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getAnswerTo()
    {
        return $this->answerTo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserDetails()
    {
        return $this->userDetails;
    }
}