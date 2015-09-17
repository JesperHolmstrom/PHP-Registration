<?php
/**
 * Created by PhpStorm.
 * User: Jesper
 * Date: 2015-09-16
 * Time: 14:41
 */

class DatabaseModel{
    private static $correctUser = "Admin";
    private static $correctPass = "Password";

    public function verify($username, $password){
        if($username == self::$correctUser && $password == self::$correctPass){
            $this->isLoggedIn = true;
            return true;
        }
        else{
            $this->isLoggedIn = false;
            return false;
        }
    }
}