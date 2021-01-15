<?php


class Type
{
    public static $categories = ["games", "music", "series", "movie", "book", "youtube", "instagram"];

    private $title;
    private $description;
    private $image;
    private $category;

    // zrobić po swojemu

    private $like;
    private $dislike;
    private $id;

    public function __construct($title, $description, $image, $category, $like = 0, $dislike = 0, $id = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->category = $category;
        $this->like = $like;
        $this->dislike = $dislike;
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

    public function getLike(): int
    {
        return $this->like;
    }

    public function getDislike(): int
    {
        return $this->dislike;
    }

    public function getId()
    {
        return $this->id;
    }
}