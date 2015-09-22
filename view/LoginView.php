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

		if($_SESSION['Login'] == true){ //User is already logged in
			if($this->userWantsToLogout()){
				$_SESSION["Login"] = false;
				$response = $this->generateLoginFormHTML("Bye bye!", "");
				session_destroy();

				//Destroy cookies if there are any
				if (isset($_COOKIE[self::$cookieName])) {
					unset($_COOKIE[self::$cookieName]);
					setcookie(self::$cookieName, '', time() - 3600, '/'); // empty value and old timestamp
				}
				if (isset($_COOKIE[self::$cookiePassword])) {
					unset($_COOKIE[self::$cookiePassword]);
					setcookie(self::$cookiePassword, '', time() - 3600, '/'); // empty value and old timestamp
				}
			}
			else{ //Remove message on reload
				$message = "";
				$response = $this->generateLogoutButtonHTML($message);
			}
		}
		else if(!$this->userWantsToLogin() && !$this->userWantsToLogout()){ //Remove message on reload
			$message = "";
			$response = $this->generateLoginFormHTML($message, "");
		}
		else if($this->userWantsToLogout()){
			if($_SESSION["Login"] == true) //Show bye bye message when user wants to log out
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
			else{ //successfull login
				$message = "Welcome";
				$_SESSION["Login"] = true;
				// Set a cookie that expires in 24 hours if 'keep' checkbox is checked
				if($this->keepLogin()){
					setcookie(self::$cookieName,$user, time()+3600*24);
					setcookie(self::$cookiePassword,$pass, time()+3600*24);
				}
				$response = $this->generateLogoutButtonHTML($message);

			}
		}
		if($this->isThereAnyCookies() && $_SESSION["Login"] == false){ //Login with cookies
			if($this->databaseModel->verify($_COOKIE[self::$cookieName], $_COOKIE[self::$cookiePassword])){
				$message = "Welcome back with cookie";
				$_SESSION["Login"] = true;
				$response = $this->generateLogoutButtonHTML($message);
			}
			else{
				$message = "Wrong information in cookies";
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

	//Is there any cookies available?
	private function isThereAnyCookies(){
		return isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword]);
	}
}