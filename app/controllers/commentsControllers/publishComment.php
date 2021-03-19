<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

use \App\Comments;
use \App\User;

@include '../../DB/DB.php';
@include '../../Comments/Comments.php';
@include '../../User/User.php';

// 获取用户id
$user = new User\User;
$author_id = $user->getUserId($_COOKIE['username'])[0]['id'];

$comment_info = [
  'author_id' => $author_id,
  'article_id' => $_POST['articleId'],
  'content' => $_POST['comment']
];

$comments = new Comments\Comments;
echo json_encode($comments->publishComment($comment_info));
