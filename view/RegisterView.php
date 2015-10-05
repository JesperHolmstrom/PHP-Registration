<?php

    require_once("model/UserModel.php");

class RegisterView {

    private static $registrationURL = "register";

	private static $register = "RegisterView::Register";
    private static $message = "RegisterView::Message";
    private static $user = "RegisterView::UserName";
    private static $pass = "RegisterView::Password";
    private static $passRepeat = "RegisterView::PasswordRepeat";

    private $registrationSucceeded = false;
    private $registrationFailed = false;

    private static $sessionSaveLocation;
    private static $userSaveLocation;

    public function __construct() {
        self::$sessionSaveLocation = Settings::MESSAGE_SESSION_NAME . Settings::APP_SESSION_NAME;
        self::$userSaveLocation = Settings::USER_SESSION_NAME . Settings::APP_SESSION_NAME;
    }

    public function response() {
        return $this->doRegisterForm();
    }

    private function doRegisterForm(){
        $message = "";
        if($this->userWantsToRegister()){
            if(strlen($this->getUserName()) < 3)
                $message .= "Username has too few characters, at least 3 characters.";
            if($this->getPassword() !== $this->getPasswordRepeat())
                $message .= "Passwords do not match.";
            if(strlen($this->getPassword()) < 6)
                $message .= "Password has too few characters, at least 6 characters.";
            if(!ctype_alnum($this->getUserName())){
                $message .= "Username contains invalid characters.";
                $this->removeHTMLTags();
            }

            if($this->registrationFailed)
                $message = "User exists, pick another username.";
        }
        return $this->generateRegisterForm($message);
    }

    private function generateRegisterForm($message){
        return '<h2>Register new user</h2>
                <form action="?register" method="post" enctype="multipart/form-data">
                    <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                        <p id="'.self::$message.'">'.$message.'</p>
                        <label for="'.self::$user.'">Username :</label>
                        <input type="text" size="20" name="'.self::$user.'" id="'.self::$user.'" value="'.$this->getUserName().'">
                        <br>
                        <label for="'.self::$pass.'">Password  :</label>
                        <input type="password" size="20" name="'.self::$pass.'" id="'.self::$pass.'" value="">
                        <br>
                        <label for="'.self::$passRepeat.'">Repeat password  :</label>
                        <input type="password" size="20" name="'.self::$passRepeat.'" id="'.self::$passRepeat.'" value="">
                        <br>
                        <input id="submit" type="submit" name="'.self::$register.'" value="Register">
                        <br>
                    </fieldset>
                </form>';
    }

    public function userClickedOnRegister(){
        return isset($_GET[self::$registrationURL]);
    }

    public function getRegistrationLink(){
        return '<a href="?' . self::$registrationURL . '">Register a new user</a>';
    }

    public function getBackLink(){
        return '<a href="?">Back to login</a>';
    }

    public function userWantsToRegister(){
        return isset($_POST[self::$register]);
    }

    public function getUserName(){
        if(isset($_POST[self::$user])){
            return $_POST[self::$user];
        }
    }

    public function getPassword(){
        if(isset($_POST[self::$pass])){
            return $_POST[self::$pass];
        }
    }

    public function getPasswordRepeat(){
        if(isset($_POST[self::$passRepeat])){
            return $_POST[self::$passRepeat];
        }
    }

    public function getUserModel(){
        return new UserModel($this->getUserName(), $this->getPassword());
    }

    public function formIsValid(){
        //TODO: Not nice to have validation here and in doRegisterForm, refactor this
        return strlen($this->getUserName()) > 2
            && strlen($this->getPassword()) > 5
            && ($this->getPassword() === $this->getPasswordRepeat())
            && ctype_alnum($this->getUserName());
    }

    public function setRegistrationSucceeded(){
        $_SESSION[self::$sessionSaveLocation] = "Registered new user.";
        $_SESSION[self::$userSaveLocation] = $this->getUserName();
        unset($_GET[self::$registrationURL]);
        $this->registrationSucceeded = true;
    }

    public function registrationSucceeded(){
        return $this->registrationSucceeded;
    }

    public function setRegistrationFailed(){
        $this->registrationFailed = true;
    }

    public function removeHTMLTags(){
        $username = $this->getUserName();
        $_POST[self::$user] = strip_tags($username);
    }


}