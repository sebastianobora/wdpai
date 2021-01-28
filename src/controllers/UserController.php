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
    private $currentUser;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->userDetailsRepository = new UserDetailsRepository();
        $this->userDetails = $this->userDetailsRepository->getUserDetailsByCookie();
        $this->currentUser = $this->userRepository->getUserByCookie($_COOKIE["user"]);
        $this->messages = [];
    }

    public function user($username){
        $fetchedUserDetails = $this->userDetailsRepository->getUserDetailsByUsername($username);
        $this->render('user', ['fetchedUserDetails' => $fetchedUserDetails, 'userDetails' => $this->userDetails]);
    }

    public function editUser($username){
        if($this->isPost()){
            $this->messages = ["Your account details has been updated successfully!"];
            $editedUser = $this->userRepository->getUserByUsername($_POST['username']);
            $this->accessToEdit($editedUser->getUserId(),$this->currentUser);
            $this->updateUsersFields($editedUser);
        }
        if($this->isPost() && $username == ''){
            $username = $_POST['username'];
        }
        $fetchedUserDetails = $this->userDetailsRepository->getUserDetailsByUsername($username);
        $this->render('edit-user',
            ['fetchedUserDetails' => $fetchedUserDetails, 'userDetails' => $this->userDetails, 'messages' => $this->messages]);
    }

    public function updateUsersFields($editedUser){
        if(is_uploaded_file($_FILES['file']['tmp_name']) && $this->validateFile($_FILES['file'])) {
            $file = $this->prepareFile($_FILES['file']);
            $this->userDetailsRepository->updateUserDetailsField("image", $file, $_POST['username']);
        }
        $this->userDetailsRepository->updateUserDetailsField("name", $_POST['name'], $_POST['username']);
        $this->userDetailsRepository->updateUserDetailsField("surname", $_POST['surname'], $_POST['username']);
        $this->userDetailsRepository->updateUserDetailsField("phone", $_POST['phone'], $_POST['username']);

        if($_POST['password'] != '' && $_POST['newPassword'] != '' && $_POST['newPassword'] != ''){
            if(hash("sha256",$_POST['password']) == $editedUser->getPassword()){
                if($_POST['newPassword'] == $_POST['confirmNewPassword']){
                    $this->userRepository->changePassword(hash("sha256",$_POST['newPassword']), $editedUser->getUserId());
                }else{
                    $this->messages = ["Passwords do not match!"];
                }
        }else{
                $this->messages = ["Wrong password!"];
            }
        }
    }

    public function deleteUser($username){
        if($this->isPost()){
            $deletedUser = $this->userRepository->getUserByUsername($_POST['username']);
            $this->accessToEdit($deletedUser->getUserId(), $this->currentUser);
            if(isset($_POST['password']) && hash("sha256",$_POST['password']) == $deletedUser->getPassword()){
                $this->userDetailsRepository->deleteUserUserDetails($_POST['username']);
                setcookie("user", "", time() - 3600);
                $url = "http://$_SERVER[HTTP_HOST]";
                header("location: {$url}/index");
            }
        }

        $fetchedUserDetails = $this->userDetailsRepository->getUserDetailsByUsername($username);
        $this->render('delete-user', ['fetchedUserDetails' => $fetchedUserDetails, 'userDetails' => $this->userDetails, 'messages' => $this->messages]);
    }
}
