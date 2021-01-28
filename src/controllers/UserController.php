<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/UserDetailsRepository.php';

class UserController extends AppController{
    private $messages;
    private $userRepository;
    private $userDetailsRepository;
    private $userDetails;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->userDetailsRepository = new UserDetailsRepository();
        $this->userDetails = $this->userDetailsRepository->getUserDetailsByCookie();
        $this->messages = [];
    }

    public function user($username){
        $fetchedUserDetails = $this->userDetailsRepository->getUserDetailsByUsername($username);
        $this->render('user', ['fetchedUserDetails' => $fetchedUserDetails, 'userDetails' => $this->userDetails]);
    }

    public function editUser($username){
        if($this->isPost()){
            $this->messages = ["Your account details has been updated successfully!"];
            if(is_uploaded_file($_FILES['file']['tmp_name']) && $this->validateFile($_FILES['file'])) {
                $file = $this->prepareFile($_FILES['file']);
                $this->userDetailsRepository->updateUserDetailsField("image", $file, $_POST['username']);
            }
            if(isset($_POST['name'])){
                $this->userDetailsRepository->updateUserDetailsField("name", $_POST['name'], $_POST['username']);
            }
            if(isset($_POST['surname'])){
                $this->userDetailsRepository->updateUserDetailsField("surname", $_POST['surname'], $_POST['username']);
            }
            if(isset($_POST['phone'])){
                $this->userDetailsRepository->updateUserDetailsField("phone", $_POST['phone'], $_POST['username']);
            }
            if(hash("sha256",$_POST['password']) == $this->userRepository->getUserByUsername($_POST['username'])->getPassword()){
                if($_POST['newPassword'] != "" && $_POST['newPassword'] == $_POST['confirmNewPassword']){
                    $user = $this->userRepository->getUserByUsername($_POST['username']);
                    $this->userRepository->changePassword(hash("sha256",$_POST['newPassword']), $user->getUserId());
                }else{
                    $this->messages = ["Passwords do not match!"];
                }
            }else if($_POST['password'] != ''){
                $this->messages = ["Wrong password!"];
            }
        }
        if($username == ''){
            $username = $_POST['username'];
        }
        $fetchedUserDetails = $this->userDetailsRepository->getUserDetailsByUsername($username);
        $this->render('edit-user',
            ['fetchedUserDetails' => $fetchedUserDetails, 'userDetails' => $this->userDetails, 'messages' => $this->messages]);
    }
}
