<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json;charset:utf-8');

use \App\Uploader\VideoUploader;
use \App\User;
use \App\DB;

include '../../Uploader/VideoUploader.php';
include '../../Uploader/Uploader.php';
include '../../User/User.php';
include '../../DB/DB.php';

$username = $_COOKIE['username'];

// 存储文件
$uploader = new VideoUploader\VideoUploader($username);
$info = $uploader->make();
$poster = $info['poster']['poster'];
$source = $info['source']['source'];

// 获取用户id
$user = new User\User;
$user_id = $user->getUserId($username)[0]['id'];

// 视频描述
$desc = $_POST['desc'];

// 分类标签
$tag = $_POST['tag'];

// 存入数据库
$db = new DB\DB;
$sql = "INSERT videos(author_id, poster, src, `desc`, tag)
VALUES (:author_id, :poster, :src, :desc, :tag)";
$vars = [
  'author_id' => $user_id,
  'poster' => $poster,
  'src' => $source,
  'desc' => $desc,
  'tag' => $tag
];

try {
  $status = $db->insert($sql, $vars);
  echo json_encode($status);
} catch (Exception $e) {
  echo json_encode(0);
  die(0);
}
