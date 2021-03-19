<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

use \App\Reply;
use \App\User;

@include '../../DB/DB.php';
@include '../../Reply/Reply.php';
@include '../../User/User.php';
@include '../../Comments/Comments.php';

$user = new User\User;
$user_id = $user->getUserId($_COOKIE['username'])[0]['id'];

$reply = new Reply\Reply;
$replys = $reply->getUserReplys($user_id);
echo json_encode($replys);
