<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

use \App\Reply;
use \App\User;

@include '../../DB/DB.php';
@include '../../Reply/Reply.php';
@include '../../User/User.php';

// 获取收发件人用户id
$user = new User\User;
$from_username = $_COOKIE['username'];
$from_user_id = $user->getUserId($from_username)[0]['id'];
$to_username = $_POST['to'];
$to_user_id = $user->getUserId($to_username)[0]['id'];

$replyInfo = [
  'to_user_id' => (int)$to_user_id,
  'from_user_id' => (int)$from_user_id,
  'comment_id' => (int)$_POST['comment_id'],
  'content' => $_POST['content']
];

$reply = new Reply\Reply;
echo json_encode($reply->postReply($replyInfo));
