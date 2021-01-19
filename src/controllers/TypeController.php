<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Type.php';
require_once __DIR__.'/../repository/TypeRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/UserDetailsRepository.php';

class TypeController extends AppController{
    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', "image/jpeg"];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $message = [];
    private $typeRepository;
    private $userRepository;
    private $userDetailsRepository;

    private $userDetails;

    public function __construct()
    {
        parent::__construct();
        $this->typeRepository = new TypeRepository();
        $this->userRepository = new UserRepository();
        $this->userDetailsRepository = new UserDetailsRepository();

        $this->userDetails = $this->userDetailsRepository->getUserDetailsByCookie();
    }

    public function userTypes($username){
        $userId = $this->userRepository->getUserIdByUsername($username);
        $types = $this->typeRepository->getUserTypes($userId);
        $this->render('types', ['types' => $types, 'userDetails' => $this->userDetails]);
    }

    public function favoriteTypes($username){
        $userId = $this->userRepository->getUserIdByUsername($username);
        $types = $this->typeRepository->getFavoriteTypes($userId);
        $this->render('types', ['types' => $types, 'userDetails' => $this->userDetails]);
    }

    public function type($id){
        $type = $this->typeRepository->getTypeById($id);
        $this->render('type', ['type' => $type, 'userDetails' => $this->userDetails]);
    }

    public function types($category){
        if($category){
            $types = $this->typeRepository->getTypeByCategory($category);
        }else{
            $types = $this->typeRepository->getTypes();
        }
        $this->render('types', ['types' => $types, 'userDetails' => $this->userDetails]);
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
        if($this->isPost() && $this->validate($_FILES['file']) && is_uploaded_file($_FILES['file']['tmp_name'])){
            $fileExtension = explode(".", $_FILES['file']['name']);
            $fileExtension = ".".$fileExtension[sizeof($fileExtension) - 1];

            $name = uniqid("img-");
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$name.$fileExtension
                //dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
            ); # łączymy w drugim argumencie ścieżkę do katalogu + ścieżka docelowa pliku + nzwa pliku

            $type = new Type($_POST['title'], $_POST['description'], $name.$fileExtension, $_POST['category']);
            $this->typeRepository->addType($type);

            $url = "http://$_SERVER[HTTP_HOST]";
            header("location: {$url}/types");
        }

        return $this ->render("add-types", ['messages' => $this->message, 'userDetails' => $this->userDetails, 'categories' => Type::$categories]);
    }


    private function validate(array $file): bool{
        if($file['size'] > self::MAX_FILE_SIZE){
            $this->message[] = 'File is too large for destination file system';
            var_dump($this->message);
            return false;
        }
        if(!isset($file['type']) && !in_array($file['type'], self::SUPPORTED_TYPES)){
            $this->message[] = 'File type is not supported';
            return false;
        }

        return true;
    }

    public function like (int $id){
        $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode($this->typeRepository->like($id, $decoded['value']));
        }
    }
}