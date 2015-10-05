<?php

class UserDAL{

    public function doRegistration($userName, $password){
        if (file_exists(self::getFileName($userName)))
            return false;
        else{
            file_put_contents( self::getFileName($userName), serialize($password) );
            return true;
        }
    }

    public function loadUser($userName){
        if (file_exists(self::getFileName($userName)))
            return unserialize(file_get_contents(self::getFileName($userName)));
    }

    private function getFileName($userName) {
        return Settings::USERPATH . addslashes($userName);
    }
}