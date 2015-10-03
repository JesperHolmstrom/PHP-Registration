<?php
class RegisterView {

    private static $registrationURL = "register";

	private static $register = "RegisterView::Register";
    private static $message = "RegisterView::Message";
    private static $user = "RegisterView::UserName";
    private static $pass = "RegisterView::Password";
    private static $passRepeat = "RegisterView::PasswordRepeat";

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

}