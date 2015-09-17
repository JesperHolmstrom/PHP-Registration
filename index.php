<?php
//Start a new Session
session_start();

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once('controller/PageController.php');

$pageController = new PageController();
$pageController->start();



