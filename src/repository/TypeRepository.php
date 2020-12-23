<?php

require_once "Repository.php";
require_once __DIR__."/../models/Type.php";

class TypeRepository extends Repository
{
    public function getType(int $id): ?Type
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $type = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($type == false) {
            return null;
        }

        return new Type(
            $type['title'],
            $type['description'],
            $type['image']
        );
    }

    public function addType(Type $type): void
    {
        $date = new DateTime();
        $stmt = $this->database->connect()->prepare('
        INSERT INTO types (title, description, created_at, image, id_users)
        VALUES (?, ?, ?, ?, ?)');

        ## tutaj dorobić wyciągnięcie po ciasteczku pobieranie id osoby, która dodaje projekt
        $tempId = 4;

        $stmt->execute([
            $type->getTitle(),
            $type->getDescription(),
            $date->format('Y-m-d'),
            $type->getImage(),
            $tempId
        ]);
    }

    public function getTypes(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM types
        ');
        $stmt->execute();
        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($types as $type){
            $result[] = new Type(
                $type['title'],
                $type['description'],
                $type['image']
            );
        }

        return $result;
    }
}