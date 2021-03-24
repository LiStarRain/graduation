<?php

use App\DB;

@include '../../DB/DB.php';

header('Access-Control-Allow-origin: *');
header('Content-type: application/json');

$db = new DB\DB;
// 获取图片的目录
$get_path = "SELECT img FROM glance_images WHERE id = :id";
$path = $db->query($get_path, ['id' => $_POST['id']])[0]['img'];
$path = preg_replace('/^https?:\/\/localhost:8888\//', '../../', $path);

if (is_file($path)) {
  $deleteStatus = unlink($path);
}


$sql = "DELETE FROM glance_images WHERE id = :id";
$dbStatus = $db->execute($sql, ['id' => $_POST['id']]);
echo json_encode($deleteStatus && $dbStatus);
