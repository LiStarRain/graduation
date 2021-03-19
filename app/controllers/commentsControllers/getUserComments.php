<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

use \App\User;
use \App\Comments;

@include '../../DB/DB.php';
@include '../../Reply/Reply.php';
@include '../../User/User.php';
@include '../../Comments/Comments.php';

$user = new User\User;
$user_id = $user->getUserId($_COOKIE['username'])[0]['id'];
// 获取该用户发表过的所有文章
$articles = $user->getArticles($user_id);
// 获取文章的所有评论
$comments = [];
$com = new Comments\Comments;
foreach ($articles as $article_id) {
  $res = $com->getComments((int)$article_id['id']);
  if (count($res) > 0) {
    $res[] = (int)$article_id['id'];
    $comments[] = $res;
  }
}

$res = [];
foreach ($comments as $field) {
  for ($i = 0; $i < count($field) - 1; $i++) {
    $res[] = [
      'data' => $field[$i],
      'article_id' => $field[count($field) - 1]
    ];
  }
}
echo json_encode($res);
