<?php
// 登录注册操作
session_start();

use \App\User;
use \App\Uploader;
use \App\Thumb;


include '../../User/User.php';
include '../../DB/DB.php';
include '../../User/UserInfo.php';
include '../../Uploader/Uploader.php';
include '../../Thumb/Thumb.php';

// 跨域
header('Access-Control-Allow-Origin: *');
// 设置返回头
header('Content-type: application/json; charset:utf-8');

// setcookie('username','Ame',time() + 60 * 60 * 24);
// setcookie('username', '', 1);

$user = new User\User;
$action = $_GET['action'] ?? $_POST['action'];
switch ($action) {
  case 'getLoginStatus':
    echo json_encode($user->getLoginStatus());
    break;
  case 'getUserInfo':
    // 从cookie获取username
    $username = $_COOKIE['username'];
    $data = $user->getUserInfo($username);
    echo json_encode($data);
    break;
  case 'login':
    $email = $_POST['email'];
    $password = $_POST['password'];
    $captcha = strtolower($_POST['captcha']);
    if ($captcha === $_SESSION['captcha']) {
      $data = $user->login($email, $password);
      echo json_encode($data);
    } else {
      echo json_encode('验证码不匹配');
    }
    break;
  case 'logout':
    $status = $user->logout();
    echo json_encode($status);
    break;
  case 'register':
    $captcha = strtolower($_POST['captcha']);
    if ($captcha === $_SESSION['captcha']) {
      // 判断用户是否上传了头像
      if (!count($_FILES)) {
        $head_img = null;
      } else {
        // head_img要先通过文件上传和图像处理类来先处理
        $uploader = new Uploader\Uploader;
        $thumb = new Thumb\Thumb;
        $head_info = $uploader->make()[0];
        $head_img = $head_info['path'];
        $thumb->make($head_info['filePath'], $head_info['filePath'], 50, 50);
      }
      $accountInfo = [
        "username" => $_POST["username"],
        "password" => $_POST["password"],
        "email" => $_POST["email"],
        "sex" => $_POST["sex"],
        "age" => $_POST["age"],
        "birthday" => $_POST["birthday"],
        "head_img" => $head_img
      ];
      $status = $user->register($accountInfo);
      echo json_encode($status);
    } else {
      echo json_encode('验证码不匹配');
    }
    break;
  default:
    echo 'This is a loginController';
}
