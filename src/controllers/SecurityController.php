<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController{
    private $userRepository;
    private $userDetailsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->userDetailsRepository = new UserDetailsRepository();
    }

    public function login(){
        if(!$this->isPost()){
            return $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $this->userRepository->getUser($email);

        if(!$user){
            return $this->render('login', ['messages' => ["User with this email not exist!"]]);
        }

        if($user -> getEmail() !== $email ){
            return $this->render('login', ['messages' => ["User with this email not exist!"]]);
        }
        //TODO: to u góry chyba już można usunąć
        if($user -> getPassword() !== md5($password)){
            return $this->render('login', ['messages' => ["Wrong password!"]]);
        }

        //return $this->render('types');
        $cookieValue = md5($user->getEmail());
        setcookie("user", $cookieValue , time() + (86400));
        $this-> userRepository->setCookie($cookieValue, $user->getEmail());

        $url = "http://$_SERVER[HTTP_HOST]";
        header("location: {$url}/types");
    }

    public function logout(){
        $user = $this->userRepository->getUserByCookie($_COOKIE["user"]);
        $this->userRepository->setCookie(null, $user->getEmail());
        setcookie("user", "", time() - 3600);
        $this->render('login');
    }

    public function register(){
        if(!$this->isPost()){
            return $this->render('register');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $username = $_POST['username'];
        $confirmedPassword = $_POST['confirmedPassword'];

        $user = $this->userRepository->getUser($email);

        if(!$email or !$password){
            return $this->render('register',['messages' => ["Fields can't be empty"]] );
        }

        if($user)
        {
            return $this->render('register', ['messages' => ["User with this email already exist!"]]);
        }
        if($password != $confirmedPassword)
        {
            return $this->render('register', ['messages' => ["Passwords do not match!"]]);
        }

        $user = new User($email, md5($password), $username);
        $detailsId = $this->userDetailsRepository->createUserDetails($user->getUsername());
        $this->userRepository->addUser($user, $detailsId);

        $this->render('login', ['messages' => ["Account created properly, now you can log in!"]]);
    }
}