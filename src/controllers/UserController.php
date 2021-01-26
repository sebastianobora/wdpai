<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class UserController extends AppController{
    private $message = [];
    private $userRepository;
    private $userDetailsRepository;

    private $userDetails;


    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->userDetailsRepository = new UserDetailsRepository();

        $this->userDetails = $this->userDetailsRepository->getUserDetailsByCookie();
    }

    public function user($username){
        $fetchedUserDetails = $this->userDetailsRepository->getUserDetailsByUsername($username);
        $this->render('user', ['fetchedUserDetails' => $fetchedUserDetails, 'userDetails' => $this->userDetails]);
    }
}
