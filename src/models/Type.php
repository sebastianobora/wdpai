<?php


class Type
{
    public static $categories = ["games", "music", "series", "movie", "book", "youtube", "instagram"];

    private $title;
    private $description;
    private $image;
    private $category;

    private $likes;
    private $dislikes;
    private $id;

    public function __construct($title, $description, $image, $category, $likes = 0, $dislikes = 0, $id = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->category = $category;
        $this->likes = $likes;
        $this->dislikes = $dislikes;
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    public function getId()
    {
        return $this->id;
    }
}