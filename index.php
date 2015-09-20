<?php
//Start a new Session
session_start();
date_default_timezone_set('Europe/Stockholm');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER


require_once('controller/PageController.php');
$pageController = new PageController();
$pageController->start();




