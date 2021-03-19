<?php
// 获取视频分类
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

use \App\DB;

include '../../DB/DB.php';


$db = new DB\DB;
$sql = "SELECT tag,img,`desc` FROM video_categories";

$res = $db->query($sql);
echo json_encode($res);
