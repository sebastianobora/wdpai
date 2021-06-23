<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/UserDetailsRepository.php';

class UserController extends AppController
{
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
    }

    public function user($username)
    {
        $admin = $this->userRepository->isAdmin();
        $fetchedUserDetails = $this->userDetailsRepository->getUserDetailsByUsername($username);
        $this->render('user', ['fetchedUserDetails' => $fetchedUserDetails, 'userDetails' => $this->userDetails, 'admin' => $admin]);
    }

    public function editUser($username)
    {
        if ($this->isPost()) {
            $this->messages = ["Your account details has been updated successfully!"];
            $editedUser = $this->userRepository->getUserByUsername($_POST['username']);

            !$this->accessToEdit($editedUser->getUserId(), $this->currentUser, $this->userRepository->isAdmin()) ?:
                $this->updateUser($editedUser);
        }
        if ($this->isPost() && $username == '') {
            $username = $_POST['username'];
        }
        $fetchedUserDetails = $this->userDetailsRepository->getUserDetailsByUsername($username);
        $this->render('edit-user',
            ['fetchedUserDetails' => $fetchedUserDetails, 'userDetails' => $this->userDetails, 'messages' => $this->messages]);
    }

    public function updateImage(): void
    {
        if ($this->isUploadedFile() && $this->isValidFile()) {
            $file = $this->prepareFile($_FILES['file']);
            $this->userDetailsRepository->updateUserDetailsField("image", $file, $_POST['username']);
        }
    }

    public function isPhoneInvalid(): bool
    {
        $isInvalid = (strlen($_POST['phone']) < 0) || (strlen($_POST['phone']) > 9);
        if ($isInvalid) {
            $this->messages = ["Wrong phone number!"];
        }
        return $isInvalid;
    }

    public function arePasswordsNotEmpty(): bool
    {
        return $_POST['password'] != '' && $_POST['newPassword'] != '';
    }

    public function checkPasswords($user): bool{
        $passwordsMatch = hash("sha256", $_POST['password']) == $user->getPassword();
        if (!$passwordsMatch) {
            $this->messages = ["Wrong password!"];
        }
        return $passwordsMatch;
    }

    public function arePasswordsMatch(): bool
    {
        $passwordsMatch = $_POST['newPassword'] == $_POST['confirmNewPassword'];
        if (!$passwordsMatch) {
            $this->messages = ["Passwords do not match!"];
        }
        return $passwordsMatch;
    }

    public function updateUser($editedUser)
    {
        $this->updateImage();
        $this->userDetailsRepository->updateUserDetailsField("name", $_POST['name'], $_POST['username']);
        $this->userDetailsRepository->updateUserDetailsField("surname", $_POST['surname'], $_POST['username']);
        $this->isPhoneInvalid() ?:
            $this->userDetailsRepository->updateUserDetailsField("phone", $_POST['phone'], $_POST['username']);

        if ($this->arePasswordsNotEmpty() && $this->checkPasswords($editedUser) && $this->arePasswordsMatch()) {
            $this->userRepository->changePassword(hash("sha256", $_POST['newPassword']), $editedUser->getUserId());
        }
    }

    public function hasAccessToDelete($deletedUser): bool
    {
        return $this->checkPasswords($deletedUser) or $this->userRepository->isAdmin();
    }

    public function logoutDeletedUser($deletedUser): void
    {
        if ($deletedUser->getUserId() == $this->currentUser->getUserId()) {
            setcookie("user", "", time() - 3600);
        }
    }

    public function deleteUser($username)
    {
        if ($this->isPost()) {
            $deletedUser = $this->userRepository->getUserByUsername($_POST['username']);
            $accessToEdit = $this->accessToEdit($deletedUser->getUserId(), $this->currentUser, $this->userRepository->isAdmin());
            $accessToDelete = $this->hasAccessToDelete($deletedUser);

            if ($accessToEdit && $accessToDelete) {
                $this->logoutDeletedUser($deletedUser);
                $this->userDetailsRepository->deleteUserUserDetails($_POST['username']);
                $url = "http://$_SERVER[HTTP_HOST]";
                header("location: {$url}/index");
            }
        }
        if ($this->isPost() && $username == '') {
            $username = $_POST['username'];
        }
        $fetchedUserDetails = $this->userDetailsRepository->getUserDetailsByUsername($username);
        $this->render('delete-user',
            ['fetchedUserDetails' => $fetchedUserDetails, 'userDetails' => $this->userDetails, 'messages' => $this->messages]);
    }
}
