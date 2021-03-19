<?php
use \App\User;
include './User.php';

// 跨域
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
$user = new User\User;

echo json_encode($user->login('Ame','ame990430'));
// $user->logout();
// echo $_SESSION['username'];
