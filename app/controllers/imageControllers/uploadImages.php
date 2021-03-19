<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json;charset = utf-8');

use App\Uploader\GlanceUploader;
use \App\User;
use \App\DB;

include '../../Uploader/Uploader.php';
include '../../Uploader/GlanceUploader.php';
include '../../User/User.php';
include '../../DB/DB.php';

// 图片标签
$tag = $_POST['tag'];

// 图片描述 
$desc = $_POST['desc'];

// 获取用户名
$username = $_COOKIE['username'];
// 获取用户id
$user = new User\User;
$userId = $user->getUserId($username)[0]['id'];

// 将图片保存至本地
$uploader = new GlanceUploader\GlanceUploader($username);
$images = $uploader->make();

// 存入数据库
$db = new DB\DB;
$sql = 'INSERT glance_images(author_id,img,`desc`,tag)
values (:author_id,:img,:desc,:tag)';
try {
  foreach ($images as $image) {
    $vars = [
      'author_id' => $userId,
      'img' => $image['img'],
      'desc' => $desc,
      'tag' => $tag
    ];
    $db->insert($sql, $vars);
  }
  echo json_encode(1);
} catch (Exception $e) {
  echo json_encode(0);
}
