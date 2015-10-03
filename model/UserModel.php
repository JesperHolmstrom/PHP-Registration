<?php

require_once("UserDAL.php");

class UserModel
{
    private $user;
    private $password;
    private $dal;

    public function __construct($user, $password){
        $this->user = $user;
        $this->password = $password;
        $this->dal = new UserDAL();
    }

    public function getUserName(){
        return $this->user;
    }

    public function getPassword(){
        return $this->password;
    }

    public function registerUser(){
        return $this->dal->doRegistration($this->user, $this->password);
    }

}