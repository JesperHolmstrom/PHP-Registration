<?php
/**
  * Solution for assignment 2
  * @author Daniel Toll
  */
require_once("model/LoginModel.php");
require_once("view/LoginView.php");

class LoginController {

	private $model;
	private $view;
	private $registerView;

	public function __construct(LoginModel $model, LoginView $view, RegisterView $registerView) {
		$this->model = $model;
		$this->view =  $view;
		$this->registerView = $registerView;
	}

	public function doControl() {
		
		$userClient = $this->view->getUserClient();

		if ($this->model->isLoggedIn($userClient)) {
			if ($this->view->userWantsToLogout()) {
				$this->model->doLogout();
				$this->view->setUserLogout();
			}
		} else {
			
			if ($this->view->userWantsToLogin()) {
				$uc = $this->view->getCredentials();
				if ($this->model->doLogin($uc) == true) {
					$this->view->setLoginSucceeded();
				} else {
					$this->view->setLoginFailed();
				}
			}
			else if($this->registerView->userWantsToRegister()){
			}
		}
		$this->model->renew($userClient);
	}
}