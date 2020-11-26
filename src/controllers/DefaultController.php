<?php

require_once 'AppController.php';

class DefaultController extends AppController{
    public function index(){
        // TODO display login.php
        $this->render('login');
    }

    public function types(){

        $this->render('types');
        // TODO display add-types.php
    }
}

