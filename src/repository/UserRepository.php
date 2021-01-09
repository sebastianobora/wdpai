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
            $user['password']
        );
    }

    public function createUserDetails(){//TODO: osobny controller?
        $stmt = $this->database->connect()->prepare('
        INSERT INTO users_details (image) VALUES (?) RETURNING id;
        ');
        $stmt->execute(["placeholderAvatar.png"]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    }

    public function addUser(User $user)
    {
        $detailsId = $this->createUserDetails();

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