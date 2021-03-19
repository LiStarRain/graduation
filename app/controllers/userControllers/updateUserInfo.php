<?php
header('Access-Control-Allow-Origin: *');
// 设置返回头
header('Content-type: application/json; charset:utf-8');

use \App\User;
use \App\Thumb;
use \App\Uploader;

include '../../User/User.php';
include '../../DB/DB.php';
include '../../Thumb/Thumb.php';
include '../../Uploader/Uploader.php';

if (isset($_FILES["head_img"])) {
  $uploader = new Uploader\Uploader;
  $head_info = $uploader->make()[0];
  $head_img = $head_info['path'];
  $thumb = new Thumb\Thumb;
  $thumb->make($head_info['filePath'], $head_info['filePath'], 50, 50);
} else {
  $head_img = null;
}

$user = new User\User;
$user_info = [
  'username' => $_POST['username'],
  'age' => $_POST['age'],
  'sex' => $_POST['sex'],
  'birthday' => $_POST['birthday'],
  'head_img' => $head_img
];
$status = $user->updateUserInfo($user_info);
echo json_encode($status);
