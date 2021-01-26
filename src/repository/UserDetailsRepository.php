<?php

require_once "Repository.php";
require_once __DIR__."/../models/User.php";
require_once __DIR__."/../models/UserDetails.php";

class UserDetailsRepository extends Repository
{
    public function getUserDetailsByUsername(string $username): ?UserDetails
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users_details WHERE username = :username
        ');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userDetails == false) {
            return null;
        }

        return new UserDetails(
            $userDetails['username'],
            $userDetails['image'],
            $userDetails['name'],
            $userDetails['surname'],
            $userDetails['phone']
        );
    }

    public function createUserDetails($username){
        $stmt = $this->database->connect()->prepare('
        INSERT INTO users_details (image, username) VALUES (?, ?) RETURNING id;
        ');
        $stmt->execute(["placeholderAvatar.png", $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    }

    public function getUserDetailsByCookie(): UserDetails
    {
        $stmt = $this->database->connect()->prepare(
            'SELECT image, username FROM users JOIN users_details ON users.id_users_details = users_details.id WHERE cookie = :cookie'
        );
        $stmt->execute([$_COOKIE['user']]);
        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);
        return new UserDetails($userDetails['username'], $userDetails['image']);
    }
}