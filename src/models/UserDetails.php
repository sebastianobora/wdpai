<?php


class UserDetails
{
    private $name;
    private $surname;
    private $phone;
    private $image;
    private $username;
    
    public function __construct($username, $image, $name = null, $surname = null, $phone = null)
    {
        $this->username = $username;
        $this->image = $image;
        $this->name = $name;
        $this->surname = $surname;
        $this->phone = $phone;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getUsername()
    {
        return $this->username;
    }
}