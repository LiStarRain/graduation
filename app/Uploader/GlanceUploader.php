<?php

namespace App\Uploader\GlanceUploader;

use \App\Uploader;

@include './Uploader.php';

// Glance页面图片上传类
class GlanceUploader extends Uploader\Uploader
{
  protected $username;
  public function __construct(string $username)
  {
    $this->username = $username;
  }

  // 覆写父类方法
  public function make()
  {
    // 保存图片路径
    $savePath = [];
    // 创建文件夹
    $this->makeDir();
    // 格式化数据
    $this->format();
    foreach ($this->files as $field) {
      // 检测文件
      if (is_uploaded_file($field['tmp_name'])) {
        $temp = mt_rand(1, 999) . pathinfo($field['name'])['basename'];
        $to = $this->dir . '/' . $temp;
        if (move_uploaded_file($field['tmp_name'], $to)) {
          $savePath[] = [
            'path' => $to,
            'size' => $field['size'],
            'name' => $field['name'],
            'img' => 'http://localhost:8888/images/glance/' . $this->username . '/' . $temp
          ];
        }
      }
    }
    return $savePath;
  }

  protected function makeDir()
  {
    $path = '/Users/ame/code/graduation/app/images/glance/' . $this->username;
    $this->dir = $path;
    return is_dir($path) or mkdir($path, 0775, true);
  }
}
