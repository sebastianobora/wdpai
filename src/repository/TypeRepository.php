<?php

require_once "Repository.php";
require_once __DIR__."/../models/Type.php";

class TypeRepository extends Repository
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function addType(Type $type): void
    {
        $date = new DateTime();
        $stmt = $this->database->connect()->prepare('
        INSERT INTO types (title, description, created_at, image, id_users, category)
        VALUES (?, ?, ?, ?, ?, ?)');

        $stmt->execute([
            $type->getTitle(),
            $type->getDescription(),
            $date->format('Y-m-d'),
            $type->getImage(),
            $this->userRepository->getUserId(),
            $type->getCategory()
        ]);
    }

    public function getUserTypes($userId){
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM types_statistics WHERE id_users = :id');

        $stmt->bindParam(':id',$userId, PDO::PARAM_STR);
        $stmt-> execute();
        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($types as $type) {
            $result[] = new Type(
                $type['title'],
                $type['description'],
                $type['image'],
                $type['category'],
                $type['likes'],
                $type['dislikes'],
                $type['id']
            );
        }
        return $result;
    }

    public function getTypeById($id){
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM types_statistics WHERE id = :id');
        $stmt->bindParam(':id',$id, PDO::PARAM_STR);
        $stmt-> execute();
        $type = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Type(
                $type['title'],
                $type['description'],
                $type['image'],
                $type['category'],
                $type['likes'],
                $type['dislikes'],
                $type['id']);
    }

    public function getTypes(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM types_statistics
        ');
        $stmt->execute();
        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($types as $type){
            $result[] = new Type(
                $type['title'],
                $type['description'],
                $type['image'],
                $type['category'],
                $type['likes'],
                $type['dislikes'],
                $type['id']
            );
        }
        return $result;
    }

    public function getTypeByCategory(string $categoryString): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM types_statistics WHERE LOWER(category) = :category');

        $stmt->bindParam(':category', $categoryString, PDO::PARAM_STR);
        $stmt-> execute();
        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($types as $type) {
            $result[] = new Type(
                $type['title'],
                $type['description'],
                $type['image'],
                $type['category'],
                $type['likes'],
                $type['dislikes'],
                $type['id']
            );
        }
        return $result;
    }

    public function getTypeByTitle(string $searchString): array
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM types_statistics WHERE LOWER(title) LIKE :search OR LOWER(description) LIKE :search OR LOWER(category) LIKE :search
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function like(int $typeId){
        $stmt = $this->database->connect()->prepare('
            INSERT INTO statistics ("like", user_id, type_id) 
            VALUES (true, :userId, :typeId) 
            ON CONFLICT (user_id, type_id)
            DO UPDATE SET "like" = CASE 
                WHEN statistics."like" = true 
                THEN null 
                ELSE true 
                END
            WHERE statistics.user_id = :userId AND statistics.type_id = :typeId; 
        ');

        $userId = $this->userRepository->getUserId();
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':typeId', $typeId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function dislike(int $typeId){
        $stmt = $this->database->connect()->prepare('
            INSERT INTO statistics ("like", user_id, type_id) 
            VALUES (false, :userId, :typeId) 
            ON CONFLICT (user_id, type_id)
            DO UPDATE SET "like" = CASE 
                WHEN statistics."like" = false 
                THEN null 
                ELSE false 
                END
            WHERE statistics.user_id = :userId AND statistics.type_id = :typeId; 
        ');

        $userId = $this->userRepository->getUserId();
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':typeId', $typeId, PDO::PARAM_INT);
        $stmt->execute();
    }
}