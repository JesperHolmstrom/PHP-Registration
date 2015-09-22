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

    /* Check if the username and password is correct */
    public function verify($username, $password){
        return $username == self::$correctUser && $password == self::$correctPass;
    }
}