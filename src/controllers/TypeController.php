<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Type.php';
require_once __DIR__.'/../repository/TypeRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';

class TypeController extends AppController{
    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', "image/jpeg"];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $message = [];
    private $typeRepository;
    private $userRepository;
    private $avatar;

    public function __construct()
    {
        parent::__construct();
        $this->typeRepository = new TypeRepository();
        $this->userRepository = new UserRepository();
        $this->avatar = $this->userRepository->getUserAvatar($_COOKIE["user"]);//TODO: może zostać, raczej do zmiany?
    }

    public function types(){
        $types = $this->typeRepository->getTypes();
        $this->render('types', ['types' => $types, 'avatar' => $this->avatar['image']]);
    }

    public function games(){
        $types = $this->typeRepository->getTypeByCategory('games');
        $this->render('types', ['types' => $types, 'avatar' =>$this->avatar['image']]);
    }

    public function music(){
        $types = $this->typeRepository->getTypeByCategory('music');
        $this->render('types', ['types' => $types, 'avatar' =>$this->avatar['image']]);
    }

    public function series(){
        $types = $this->typeRepository->getTypeByCategory('series');
        $this->render('types', ['types' => $types, 'avatar' =>$this->avatar['image']]);
    }

    public function movie(){
        $types = $this->typeRepository->getTypeByCategory('movie');
        $this->render('types', ['types' => $types, 'avatar' =>$this->avatar['image']]);
    }

    public function book(){
        $types = $this->typeRepository->getTypeByCategory('book');
        $this->render('types', ['types' => $types, 'avatar' =>$this->avatar['image']]);
    }

    public function youtube(){
        $types = $this->typeRepository->getTypeByCategory('youtube');
        $this->render('types', ['types' => $types, 'avatar' =>$this->avatar['image']]);
    }

    public function instagram(){
        $types = $this->typeRepository->getTypeByCategory('instagram');
        $this->render('types', ['types' => $types, 'avatar' =>$this->avatar['image']]);
    }

    public function category(){//TODO: remove
        if($this->isPost()){
            $types = $this->typeRepository->getTypeByCategory($_POST['category']);
            $this->render('types', ['types' => $types]);
        }
    }

    public function search()
    {
        $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode($this->typeRepository->getTypeByTitle($decoded['search']));
        }
    }

    public function addType(){

        # file ustailiśmy w widoku name ='file'
        if($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])){
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
            ); # łączymy w drugim argumencie ścieżkę do katalogu + ścieżka docelowa pliku + nzwa pliku

            $type = new Type($_POST['title'], $_POST['description'], $_FILES['file']['name']);
            $this->typeRepository->addType($type);

            return $this->render("types", ['messages' => $this->message, 'types' => $this->typeRepository->getTypes()]);
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