<?php

namespace App\User;

use \App\DB;
use \App\UserInfo;

@include '../DB/DB.php';
@include './UserInfo.php';

class User
{
  // 查看用户是否登录过该网站
  public function getLoginStatus()
  {
    // 若设置过相应的SESSION则代表用户登录过该网站
    if (isset($_COOKIE['username'])) {
      return true;
    } else {
      return false;
    }
  }

  // 注销用户
  public function logout()
  {
    if (isset($_COOKIE['username'])) {
      // 直接销毁cookie对应数据
      setcookie('username', '', 1, '/');
      return true;
    } else {
      return false;
    }
  }

  // 用户登录
  public function login(string $email, string $password)
  {
    // 查看数据库的用户表是否有该用户
    $db = new DB\DB;
    $sql = "SELECT * FROM account WHERE email = :email";
    $vars = ["email" => $email];
    $accountInfo = $db->query($sql, $vars);
    foreach ($accountInfo as $value) {
      if ($value['email'] == $email && $value['passwd'] == $password) {
        // 设置COOKIE
        setcookie('username', $value['username'], time() + 60 * 60 * 24 * 7, '/');
        return true;
      }
    }
    return false;
  }

  // 获取用户信息
  public function getUserInfo(string $username)
  {
    $db = new DB\DB;
    // 多表查询
    $sql = "SELECT  username,head_img,sex,age,birthday,register_time FROM account AS a
      INNER JOIN user_info AS ui
      ON a.id = ui.user_id 
      WHERE a.username = :username;";
    $res = $db->query($sql, ['username' => $username])[0];
    return new UserInfo\UserAllInfo($res);
  }

  // 注册新用户
  public function register(array $accountInfo)
  {
    $db = new DB\DB;
    // 先判断邮箱和用户名是否被占用
    $info = $db->query("SELECT email,username FROM account");
    foreach ($info as $value) {
      if ($accountInfo["email"] === $value["email"]) {
        return '邮箱被占用';
      } elseif ($accountInfo['username'] === $value['username']) {
        return '用户名被占用';
      }
    }

    // 向account表中插入数据
    $insert_account = "INSERT account(username,email,passwd)
      VALUES (:username,:email,:passwd)";
    $accountVars = ["username" => $accountInfo["username"], "email" => $accountInfo["email"], "passwd" => $accountInfo["password"]];
    $db->insert($insert_account, $accountVars);
    $user_id = $db->lastInsertId;

    // 向user_info表中插入相应数据
    if ($accountInfo['head_img']) {
      $insert_userInfo = "INSERT user_info(user_id,sex,age,head_img,birthday)
      VALUES (:user_id,:sex,:age,:head_img,:birthday)";
      $userInfoVars = [
        "user_id" => $user_id,
        "sex" => $accountInfo["sex"],
        "age" => $accountInfo["age"],
        "head_img" => $accountInfo["head_img"],
        "birthday" => $accountInfo["birthday"]
      ];
    } else {
      $insert_userInfo = "INSERT user_info(user_id,sex,age,birthday)
      VALUES (:user_id,:sex,:age,:birthday)";
      $userInfoVars = [
        "user_id" => $user_id,
        "sex" => $accountInfo["sex"],
        "age" => $accountInfo["age"],
        "birthday" => $accountInfo["birthday"]
      ];
    }
    return $db->insert($insert_userInfo, $userInfoVars);
  }

  // 获取用户id
  public function getUserId(string $username)
  {
    $db = new DB\DB;
    $sql = 'SELECT id FROM account WHERE username = :username';
    $vars = ['username' => $username];
    return $db->query($sql, $vars);
  }

  // 更新用户信息
  public function updateUserInfo(array $userInfo)
  {
    // 更新account表中的username
    $db = new DB\DB;
    $username = $_COOKIE['username'];
    $user_id = $this->getUserId($username)[0]['id'];
    $new_username = $userInfo['username'];
    $update_account = "UPDATE account SET username = :new_username WHERE id = :id";
    $account_vars = ['new_username' => $new_username, 'id' => $user_id];
    $status = $db->execute($update_account, $account_vars);
    if ($status) {
      // 更新cookie
      setcookie('username', $new_username, time() + 60 * 60 * 24 * 7, '/');
    }
    // 更新user_info表
    $update_info = "UPDATE user_info SET sex = :sex,age = :age,birthday = :birthday WHERE user_id = :id";
    $info_vars = [
      'sex' => $userInfo['sex'],
      'age' => $userInfo['age'],
      'birthday' => $userInfo['birthday'],
      'id' => $user_id
    ];
    if (!is_null($userInfo['head_img'])) {
      $update_info = "UPDATE user_info SET sex = :sex,age = :age,birthday = :birthday,head_img=:head_img WHERE user_id = :id";
      $info_vars['head_img'] = $userInfo['head_img'];
    }
    return $db->execute($update_info, $info_vars);
  }

  // 获取该用户发表过的所有文章
  public function getArticles(int $user_id)
  {
    $db = new DB\DB;
    $sql = "SELECT a.id FROM article AS a WHERE a.author_id = :author_id;";
    return $db->query($sql, ['author_id' => $user_id]);
  }
}
