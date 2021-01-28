<?php

require_once "Repository.php";
require_once __DIR__."/../models/User.php";

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['username']
        );
    }

    public function changePassword($value, $id){
        $stmt = $this->database->connect()->prepare("
        UPDATE users SET password = :value WHERE id = :id
       ");
        $stmt->bindParam(':value',$value);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
    }

    public function getUserByUsername($username){
        $stmt = $this->database->connect()->prepare(
            'SELECT users.id, email, password, username FROM users JOIN users_details ON users.id_users_details = users_details.id WHERE username = :username'
        );
        $stmt->execute([$username]);
        $user =  $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user == false) {
            return null;
        }
        return new User(
            $user['email'],
            $user['password'],
            $user['username'],
            $user['id']
        );
    }

    public function getUserId(){
        $stmt = $this->database->connect()->prepare('
        SELECT id FROM public.users WHERE cookie = :cookie');
        $stmt->execute([$_COOKIE["user"]]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    }

    public function setCookie($cookie, $email){
        $stmt = $this->database->connect()->prepare('
        UPDATE users SET cookie = :cookie WHERE email = :email
        ');
        $stmt->execute([$cookie, $email]);
    }

    public function getUserByCookie($cookie): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users WHERE cookie = :cookie
        ');
        $stmt->bindParam(':cookie', $cookie);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['username'],
            $user['id']
        );
    }

    public function addUser(User $user, $detailsId)
    {
        $stmt = $this->database->connect()->prepare('
        INSERT INTO users (email, password, id_users_details) VALUES (?, ?, ?);
        ');
        $stmt->execute([
            $user->getEmail(),
            $user->getPassword(),
            $detailsId
        ]);
    }
}