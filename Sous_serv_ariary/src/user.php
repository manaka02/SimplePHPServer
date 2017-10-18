<?php
header("Access-Control-Allow-Origin: *");

require_once ('controller/UserDataController.php');

$username = (isset($_POST['username']) ? $_POST['username'] : "" );
$device_token = (isset($_POST['expo_token']) ? $_POST['expo_token'] : "");
$password = (isset($_POST['password']) ?  $_POST['password']: "");

if(!empty($username) && !empty($device_token)){
    $deviceid = "Huawei Y6";
    $userController = new UserDataController();
    $userController->saveAccount($username, $device_token, $deviceid,$password);
}

if(isset($_GET['username'])){
	$userController = new UserDataController();
	$userController->getUserData($_GET['username']);
}
