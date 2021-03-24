<?php

namespace App\UserInfo;

class UserBaseInfo
{
  public $username;
  public $head_img;
  public function __construct(array $info)
  {
    $this->username = $info['username'];
    $this->head_img = $info['head_img'];
  }
}

class UserAllInfo extends UserBaseInfo
{
  public $age;
  public $birthday;
  public $sex;
  public $register_time;
  public $authority;
  public function __construct(array $info)
  {
    $this->username = strlen($info['username']) > 10 ? substr($info['username'], 0, 7) . str_repeat('.', 3) : $info['username'];
    $this->head_img = $info['head_img'];
    $this->age = $info['age'];
    $this->sex = $info['sex'];
    $this->register_time = $info['register_time'];
    $this->birthday = $info['birthday'];
    $this->authority = $info['authority'];
  }
}
