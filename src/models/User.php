<?php


class User
{
    private $email;
    private $password;
    private $username;
    private $userId;

    public function __construct($email, $password, $username, $userId = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}