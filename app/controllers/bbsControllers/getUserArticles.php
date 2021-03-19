<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

use App\Bbs;
use App\User;

@include '../../DB/DB.php';
@include '../../User/User.php';
@include '../../Bbs/Bbs.php';

$user = new User\User;
$user_id = $user->getUserId($_COOKIE['username'])[0]['id'];

$bbs = new Bbs\Bbs;
$res = $bbs->getUserArticles((int)$user_id);

echo json_encode($res);
