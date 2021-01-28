<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Type.php';
require_once __DIR__.'/../models/Comment.php';
require_once __DIR__.'/../repository/TypeRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/UserDetailsRepository.php';
require_once __DIR__.'/../repository/CommentRepository.php';

class TypeController extends AppController{
    private $messages;
    private $typeRepository;
    private $userRepository;
    private $userDetailsRepository;
    private $commentRepository;
    private $userDetails;
    private $currentUser;

    public function __construct()
    {
        parent::__construct();
        $this->messages = [];
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
        $type = $this->typeRepository->getTypeById($typeId);
        $author = $this->userDetailsRepository->getUserDetailsByUserId($type->getIdUsers())->getUsername();
        $comments = $this->commentRepository->getComments($typeId);
        return $this->render('type', ['type' => $type, 'userDetails' => $this->userDetails, 'comments' => $comments, 'author' => $author]);
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
        if($this->isPost() && $this->validateFile($_FILES['file']) && is_uploaded_file($_FILES['file']['tmp_name'])){
            if($_POST['title'] != '' && $_POST['description'] != ''){
                $file = $this->prepareFile($_FILES['file']);
                $type = new Type($_POST['title'], $_POST['description'], $file, $_POST['category']);
                $this->typeRepository->addType($type);
                $url = "http://$_SERVER[HTTP_HOST]";
                header("location: {$url}/types");
            }
        }
        return $this ->render("add-types", ['userDetails' => $this->userDetails, 'categories' => Type::$categories]);
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

    public function addComment(){
        $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $userId = $this->userRepository->getUserId();
            $comment = new Comment($userId, $decoded['typeId'], $decoded['message']);
            $commentId = $this->commentRepository->addComment($comment);

            header('Content-Type: application/json');
            http_response_code(200);
            $newComment = $this->commentRepository->getCommentById($commentId);

            echo json_encode(
                [
                    'id' => $newComment->getId(),
                    'userId' => $newComment->getUserId(),
                    'typeId' => $newComment->getTypeId(),
                    'message' => $newComment->getMessage(),
                    'date' => $newComment->getDate(),
                    'avatar' => $newComment->getUserDetails()->getImage(),
                    'username' => $newComment->getUserDetails()->getUsername()
                ]);
            }
    }

    public function editType($typeId){
        if($this->isPost()){
            $editedType = $this->typeRepository->getTypeById($_POST['id']);
            $this->accessToEdit($editedType->getIdUsers(), $this->currentUser);

            if(is_uploaded_file($_FILES['file']['tmp_name']) && $this->validateFile($_FILES['file'])) {
                $file = $this->prepareFile($_FILES['file']);
                $this->typeRepository->updateTypeField("image", $file, $_POST['id']);
            }
            if($_POST['title'] != '' && $_POST['description'] != '' && $_POST['category'] != ''){
                $this->typeRepository->updateTypeField("title", $_POST['title'], $_POST['id']);
                $this->typeRepository->updateTypeField("description", $_POST['description'], $_POST['id']);
                $this->typeRepository->updateTypeField("category", $_POST['category'], $_POST['id']);
            }else{
                $this->messages = ["All of fields have to be filled!"];
            }
        }
        if($this->isPost() && $typeId == ''){
            $typeId = $_POST['id'];
        }
        $type = $this->typeRepository->getTypeById($typeId);
        return $this ->render("edit-type", ['type' => $type, 'userDetails' => $this->userDetails, 'categories' => Type::$categories]);
    }

    public function deleteType($typeId){

    }
}