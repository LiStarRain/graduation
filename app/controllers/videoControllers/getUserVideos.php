<?php

use App\DB;
use App\User;

@include '../../DB/DB.php';
@include '../../User/User.php';

header('Access-Control-Allow-origin: *');
header('Content-type: application/json');

$user = new User\User;
$user_id = $user->getUserId($_COOKIE['username'])[0]['id'];

$db = new DB\DB;
$sql = "SELECT v.id,a.username,v.poster,v.`desc` ,v.src, ui.head_img FROM videos AS v
INNER JOIN account AS a
INNER JOIN user_info AS ui
WHERE v.author_id = a.id 
AND a.id = ui.user_id 
AND v.author_id  = :id
ORDER BY v.update_time DESC;";

$res = $db->query($sql, ['id' => $user_id]);
// 格式化数据
$data = [];
foreach ($res as $video) {
  $data[] = [
    'id' => $video['id'],
    'poster' => $video['poster'],
    'desc' => $video['desc'],
    'src' => $video['src'],
    "author" => [
      'name' => $video['username'],
      'head_img' => $video['head_img']
    ]
  ];
}
echo json_encode($data);
