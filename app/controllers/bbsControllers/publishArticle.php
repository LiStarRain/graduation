<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

use App\User;
use App\Bbs;

@include '../../User/User.php';
@include '../../DB/DB.php';
@include '../../Bbs/Bbs.php';

// 先获取上传者的用户id
$username = $_COOKIE['username'];
$user = new User\User;
$user_id = $user->getUserId($username)[0]['id'];
$article['author_id'] = $user_id;

$article['title'] = $_POST['article']['title'];
$article['content'] = $_POST['article']['content'];
$bbs = new Bbs\Bbs;
$status = $bbs->publish_article($article);

echo json_encode($status);
