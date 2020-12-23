<?php

require_once __DIR__.'/../../Database.php';

class Repository
{
    //TODO: jako singleton, żeby tworzył się 1 obiekt bazy danych?
    protected $database;

    public function __construct()
    {
        $this->database = new Database();
    }
}