<?php

use App\DB;
use \App\User;

@include '../../DB/DB.php';
@include '../../User/User.php';

header('Access-Control-Allow-origin: *');
header('Content-type: application/json');


$db = new DB\DB;
$user = new User\User;
$user_id = $user->getUserId($_COOKIE['username'])[0]['id'];

$sql = "SELECT id, img,`desc` FROM glance_images 
WHERE author_id = :id
ORDER BY upload_time DESC";

echo json_encode($db->query($sql, ['id' => $user_id]));
