<?php

require_once "Repository.php";
require_once __DIR__."/../models/User.php";
require_once __DIR__."/../models/UserDetails.php";

class UserDetailsRepository extends Repository
{
    public function getUserDetailsByUsername($username): ?UserDetails
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users_details WHERE username = :username
        ');
        $stmt->bindParam(':username', $username);
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

    public function getUserDetailsByUserId($userId): ?UserDetails
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users JOIN users_details ON users.id_users_details = users_details.id WHERE users.id = :userId
        ');
        $stmt->bindParam(':userId', $userId);
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

    public function updateUserDetailsField($field, $value, $username)
    {
        if($value == ""){
            $value = null;
        }
        $stmt = $this->database->connect()->prepare("
        UPDATE users_details SET $field = :value WHERE username = :username
        ");
        $stmt->bindParam(':value',$value);
        $stmt->bindParam(':username',$username);
        $stmt->execute();
    }

    public function deleteUserUserDetails($username){
        $stmt = $this->database->connect()->prepare('
        DELETE FROM users_details WHERE username =:username;
        ');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    }
}