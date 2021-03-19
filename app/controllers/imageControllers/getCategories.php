<?php
// 获取Glance页面图片分类信息
use \App\DB;

include '../../DB/DB.php';

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json;charset = utf-8');

$db = new DB\DB();

$sql = "SELECT tag,img,`desc` FROM image_categories";
$res = $db->query($sql);
echo json_encode($res);
