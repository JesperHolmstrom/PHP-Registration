<?php

class UserDAL{

    public function doRegistration($userName, $password){
        if (file_exists(self::getFileName($userName)))
            return false;
        else{
            return true;
        }
    }

    private function getFileName($userName) {
        return Settings::USERPATH . addslashes($userName);
    }
}