<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
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
        if($user -> getPassword() !== $password){
            return $this->render('login', ['messages' => ["Wrong password!"]]);
        }

        //return $this->render('types');
        setcookie("user", $user->getId(), time() + (86400 * 30));

        $url = "http://$_SERVER[HTTP_HOST]";
        header("location: {$url}/types");
    }

    public function logout(){
        setcookie("user", "", time() - 3600);
        $this->render('login');
    }

    public function register(){
        $this->render('register');
    }
}