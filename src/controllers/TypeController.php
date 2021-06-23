<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Type.php';
require_once __DIR__.'/../models/Comment.php';
require_once __DIR__.'/../repository/TypeRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/UserDetailsRepository.php';
require_once __DIR__.'/../repository/CommentRepository.php';

class TypeController extends AppController{
    private $typeRepository;
    private $userRepository;
    private $userDetailsRepository;
    private $commentRepository;
    private $userDetails;
    private $currentUser;

    public function __construct()
    {
        parent::__construct();
        $this->typeRepository = new TypeRepository();
        $this->userRepository = new UserRepository();
        $this->userDetailsRepository = new UserDetailsRepository();
        $this->commentRepository = new CommentRepository();
        $this->currentUser = $this->userRepository->getUserByCookie($_COOKIE["user"]);
        $this->userDetails = $this->userDetailsRepository->getUserDetailsByCookie();
    }

    public function userTypes($username){
        $userId = $this->userRepository->getUserByUsername($username)->getUserId();
        $types = $this->typeRepository->getUserTypes($userId);
        $this->render('types', ['types' => $types, 'userDetails' => $this->userDetails]);
    }

    public function favoriteTypes($username){
        $userId = $this->userRepository->getUserByUsername($username)->getUserId();
        $types = $this->typeRepository->getFavoriteTypes($userId);
        $this->render('types', ['types' => $types, 'userDetails' => $this->userDetails]);
    }

    public function type($typeId){
        $admin = $this->userRepository->isAdmin();
        $type = $this->typeRepository->getTypeById($typeId);
        $author = $this->userDetailsRepository->getUserDetailsByUserId($type->getIdUsers())->getUsername();
        $comments = $this->commentRepository->getComments($typeId);
        return $this->render('type', ['type' => $type, 'userDetails' => $this->userDetails, 'comments' => $comments, 'author' => $author, 'admin' => $admin]);
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

    public function isValidType(): bool{
        $isValid = $_POST['title'] != '' && $_POST['description'] != '';
        if($isValid){
            $this->messages = ["Title and description can't be empty!"];
        }
        return $isValid;
    }

    public function isTypeUploadedProperly(): bool{
        return $this->isPost() && $this->isValidFile() && $this->isValidType();
    }

    public function addType(){
        if($this->isTypeUploadedProperly()){
            $file = $this->prepareFile($_FILES['file']);
            $type = new Type($_POST['title'], $_POST['description'], $file, $_POST['category']);
            $this->typeRepository->addType($type);
            $url = "http://$_SERVER[HTTP_HOST]";
            header("location: {$url}/types");
        }
        $args = ['userDetails' => $this->userDetails, 'categories' => Type::$categories, 'messages' => $this->messages];
        return $this ->render("add-types", $args);
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

    public function isEditedTypeValid(): bool{
        $isValid = $_POST['title'] != '' && $_POST['description'] != '' && $_POST['category'] != '';
        if(!$isValid){
            $this->messages = ["All of fields have to be filled!"];
        }
        return $isValid;
    }

    public function updateType($hasAccessToEdit): void{
        if($hasAccessToEdit && $this->isValidFile() && $this->isEditedTypeValid()) {
            $file = $this->prepareFile($_FILES['file']);
            $this->typeRepository->updateTypeField("image", $file, $_POST['id']);
            $this->typeRepository->updateTypeField("title", $_POST['title'], $_POST['id']);
            $this->typeRepository->updateTypeField("description", $_POST['description'], $_POST['id']);
            $this->typeRepository->updateTypeField("category", $_POST['category'], $_POST['id']);
        }
    }

    public function editType($typeId){
        if($this->isPost()){
            $editedType = $this->typeRepository->getTypeById($_POST['id']);
            $hasAccessToEdit = $this->accessToEdit(
                $editedType->getIdUsers(),
                $this->currentUser,
                $this->userRepository->isAdmin());
            $this->updateType($hasAccessToEdit);
        }
        if($this->isPost() && $typeId == ''){
            $typeId = $_POST['id'];
        }
        $type = $this->typeRepository->getTypeById($typeId);
        return $this ->render("edit-type", ['type' => $type, 'userDetails' => $this->userDetails, 'categories' => Type::$categories]);
    }

    public function deleteType($typeId){
        $editedType = $this->typeRepository->getTypeById($typeId);
        if($this->accessToEdit($editedType->getIdUsers(), $this->currentUser, $this->userRepository->isAdmin())){
            $this->typeRepository->deleteType($typeId);
        }
        $url = "http://$_SERVER[HTTP_HOST]";
        header("location: {$url}/types");
    }
}