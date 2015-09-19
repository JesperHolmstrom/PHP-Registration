<?php

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	public $databaseModel;

	public function __construct(DatabaseModel $model){
		$this->databaseModel = $model;
	}
	

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$response = "";
		//var_dump($_SESSION["Login"]);
		if($_SESSION['Login'] == true){
			if($this->userWantsToLogout()){
				$_SESSION["Login"] = false;
				$response = $this->generateLoginFormHTML("Bye bye!", "");
				session_destroy();
			}
			else{
				$message = "";
				$response = $this->generateLogoutButtonHTML($message);
			}
		}
		else if(!$this->userWantsToLogin() && !$this->userWantsToLogout()){
			$message = "";
			$response = $this->generateLoginFormHTML($message, "");
		}
		else if($this->userWantsToLogout()){
			if($_SESSION["Login"] == true)
				$message = "Bye bye!";
			else
				$message = "";
			$response = $this->generateLoginFormHTML($message, "");
		}
		else
		{
			$user = $this->getRequestUserName();
			$pass = $this->getRequestPassword();
			if($user == ""){
				$message = "Username is missing";
				$response = $this->generateLoginFormHTML($message, $user);
			}
			else if($pass == ""){
				$message = "Password is missing";
				$response = $this->generateLoginFormHTML($message, $user);
			}
			else if(!$this->databaseModel->verify($user,$pass)){
				$message = "Wrong name or password";
				$response = $this->generateLoginFormHTML($message, $user);
			}
			else{
				$message = "Welcome";
				$_SESSION["Login"] = true;
				$response = $this->generateLogoutButtonHTML($message);

			}
		}

		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message, $user) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $user . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	//Get user name
	private function getRequestUserName() {
		if(isset($_POST[self::$name]))
			return $_POST[self::$name];
	}
	//Get Password
	private function getRequestPassword() {
		if(isset($_POST[self::$password]))
			return $_POST[self::$password];
	}
	//Is $_POST["Login"] Set?
	private function userWantsToLogin() {
		if(isset($_POST[self::$login]))
			return true;
		else
			return false;
	}
	//Is $_POST["Logout"] Set?
	private function userWantsToLogout() {
		if(isset($_POST[self::$logout]))
			return true;
		else
			return false;
	}

	//Is Keep me login checked?
	private function keepLogin(){
		return isset($_POST[self::$keep]);
	}
}