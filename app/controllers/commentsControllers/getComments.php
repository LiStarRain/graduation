<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

use \App\Comments;

@include '../../DB/DB.php';
@include '../../Comments/Comments.php';

$article_id = (int)$_GET['articleId'];

$comments = new Comments\Comments;
echo json_encode($comments->getComments($article_id));
