<?php

namespace App\Uploader;

class Uploader
{
  protected $files = [];
  // 保存的文件夹
  protected $dir;
  // 日期
  protected $fileDate;

  // 处理临时文件
  public function make()
  {
    // 存储文件路径
    $saveFiles = [];
    // 创建文件夹
    $this->makeDir();
    // 格式化数据
    $this->format();
    foreach ($this->files as $key => $file) {
      // 文件上传没有出错则处理它
      if (is_uploaded_file($file['tmp_name'])) {
        $temp = time() . mt_rand(1, 999) . '.' . pathinfo($file['name'])['extension'];
        $to = $this->dir . '/' . $temp;
        if (move_uploaded_file($file['tmp_name'], $to)) {
          $saveFiles[] = [
            'path' => 'http://localhost:8888/files/' . $this->fileDate . '/' . $temp,
            'size' => $file['size'],
            'name' => $file['name'],
            'filePath' => $to
          ];
        }
      }
    }
    return $saveFiles;
  }

  protected function makeDir()
  {
    $path = '/Users/ame/code/graduation/app/files/' . date('Y/m');
    $this->dir = $path;
    $this->fileDate = date('Y/m');
    return is_dir($path) or mkdir($path, 0777, true);
  }

  // 格式化数据
  protected function format(): array
  {
    $files = [];
    foreach ($_FILES as $field) {
      if (is_array($field['name'])) {
        foreach ($field['name'] as $id => $name) {
          $files[] = [
            'name' => $name,
            'type' => $field['type'][$id],
            'error' => $field['error'][$id],
            'size' => $field['size'][$id],
            'tmp_name' => $field['tmp_name'][$id]
          ];
        }
      } else {
        $files[] = $field;
      }
    }
    return $this->files = $files;
  }
}
