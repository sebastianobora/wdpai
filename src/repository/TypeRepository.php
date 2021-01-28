<?php

require_once "Repository.php";
require_once __DIR__."/../models/Type.php";

class TypeRepository extends Repository
{
    private UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function addType(Type $type): void
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Europe/Warsaw'));
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

    public function getTypeById($id)
    {
        $stmt = $this->database->connect()->prepare('
        SELECT id_users, created_at, title, description, image, category, likes, dislikes, ts.id,
       (SELECT "like" FROM statistics WHERE user_id = :userId AND type_id = ts.id) isliked FROM types_statistics ts WHERE id = :id');
        $userId = $this->userRepository->getUserId();
        $stmt->bindParam(':userId',$userId, PDO::PARAM_INT);
        $stmt->bindParam(':id',$id, PDO::PARAM_INT);
        $stmt-> execute();
        $type = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($type == false) {
            return null;
        }
        return $this->typeMapper([$type])[0];
    }

    public function getUserTypes($Id): array
    {
        $stmt = $this->database->connect()->prepare('
                SELECT title, description, image, category, likes, dislikes, ts.id,
       (SELECT "like" FROM statistics WHERE user_id = :userId AND type_id = ts.id) isliked FROM types_statistics ts WHERE id_users = :id');

        $userId = $this->userRepository->getUserId();
        $stmt->bindParam(':userId',$userId, PDO::PARAM_INT);
        $stmt->bindParam(':id',$Id, PDO::PARAM_INT);

        $stmt-> execute();
        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->typeMapper($types);
    }

    public function getTypes(): array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT title, description, image, category, id_users, created_at, likes, dislikes, ts.id,
       (SELECT "like" FROM statistics WHERE user_id = :id AND type_id = ts.id) isliked FROM types_statistics ts');

        $userId = $this->userRepository->getUserId();
        $stmt->bindParam(':id',$userId, PDO::PARAM_INT);
        $stmt->execute();
        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->typeMapper($types);
    }

    public function getTypeByCategory($categoryString): array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT title, description, image, category, id_users, created_at, likes, dislikes, ts.id,
       (SELECT "like" FROM statistics WHERE user_id = :id AND type_id = ts.id) isliked 
        FROM types_statistics ts WHERE LOWER(category) = :category');

        $userId = $this->userRepository->getUserId();
        $stmt->bindParam(':id',$userId, PDO::PARAM_INT);
        $stmt->bindParam(':category', $categoryString);

        $stmt-> execute();

        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->typeMapper($types);
    }

    public function getTypeByTitle($searchString): array
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT title, description, image, category, likes, dislikes, ts.id,
       (SELECT "like" FROM statistics WHERE user_id = :id AND type_id = ts.id) isliked FROM types_statistics ts WHERE LOWER(title) LIKE :search OR LOWER(description) LIKE :search OR LOWER(category) LIKE :search
        ');

        $userId = $this->userRepository->getUserId();
        $stmt->bindParam(':id',$userId, PDO::PARAM_INT);
        $stmt->bindParam(':search', $searchString);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function like(int $typeId, $value){
        $this->removeNullStatistics();

        $stmt = $this->database->connect()->prepare('
            INSERT INTO statistics ("like", user_id, type_id) 
            VALUES (:value, :userId, :typeId) 
            ON CONFLICT (user_id, type_id)
            DO UPDATE SET "like" = CASE 
                WHEN statistics."like" = :value 
                THEN null 
                ELSE :value 
                END
            WHERE statistics.user_id = :userId AND statistics.type_id = :typeId
            RETURNING statistics."like";
        ');

        $userId = $this->userRepository->getUserId();
        $stmt->bindParam(':value', $value, PDO::PARAM_BOOL);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':typeId', $typeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['like'];
    }

    public function removeNullStatistics(){
        $stmt = $this->database->connect()->prepare('
        DELETE FROM statistics WHERE "like" is null;
        ');
        $stmt->execute();
    }

    public function getFavoriteTypes($userId): array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT title, description, image, category, id_users, created_at,
       (SELECT count(*)
        FROM types t JOIN statistics s ON t.id = s.type_id
        WHERE s."like" = true AND s.type_id = types.id) likes,
       (SELECT count(*)
        FROM types t JOIN statistics s ON t.id = s.type_id
        WHERE s."like" = false AND s.type_id = types.id) dislikes, types.id,
       (SELECT "like" FROM statistics WHERE user_id = :userId AND type_id = types.id) isliked
        FROM types JOIN statistics s on types.id = s.type_id WHERE "like" = true and user_id = :userId
    ');

        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->typeMapper($types);
    }

    public function typeMapper($typesAssoc): array
    {
        $result = [];
        foreach ($typesAssoc as $type) {
            $result[] = new Type(
                $type['title'],
                $type['description'],
                $type['image'],
                $type['category'],
                $type['likes'],
                $type['dislikes'],
                $type['id'],
                $type['isliked'],
                $type['id_users'],
                $type['created_at']
            );
        }
        return $result;
    }

    public function updateTypeField($field, $value, $id)
    {
        $stmt = $this->database->connect()->prepare("
        UPDATE types SET $field = :value WHERE id = :id
        ");
        $stmt->bindParam(':value',$value);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
    }
}