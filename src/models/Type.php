<?php


class Type
{
    private $title;
    private $description;
    private $image;
    private $category;

    public function __construct($title, $description, $image, $category)
    {
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->category = $category;
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
}