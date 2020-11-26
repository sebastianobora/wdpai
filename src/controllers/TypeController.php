<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Type.php';

class TypeController extends AppController{
    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', "image/jpeg"];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $message = [];

    public function addType(){
        # file ustailiśmy w widoku name ='file'
        if($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])){
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
            ); # łączymy w drugim argumencie ścieżkę do katalogu + ścieżka docelowa pliku + nzwa pliku

            $type = new Type($_POST['title'], $_POST['description'], $_FILES['file']['name']);

            return $this->render("types", ['messages' => $this->message, 'type' => $type]);
        }

        return $this ->render("add-types", ['messages' => $this->message]);
    }

    private function validate(array $file): bool{
        if($file['size'] > self::MAX_FILE_SIZE){
            $this->message[] = 'File is too large for destination file system';
            return false;
        }
        if(!isset($file['type']) && !in_array($file['type'], self::SUPPORTED_TYPES)){
            $this->message[] = 'File type is not supported';
            return false;
        }

        return true;
    }
}