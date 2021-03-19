<?php

namespace App\Uploader\VideoUploader;


// 视频上传
class VideoUploader
{
  protected $username;
  protected $posterDir;
  protected $sourceDir;
  protected $files;
  public function __construct(string $username)
  {
    $this->username = $username;
  }
  public function make()
  {
    // 文件存储信息
    $savePath = [];
    // 创建文件夹
    $this->makeDir();
    // 格式化数据
    $this->format();
    // 存储数据
    foreach ($this->files as $file) {
      if (is_uploaded_file($file['tmp_name'])) {
        if (preg_match('/^image/', $file['type'])) {
          $posterTemp = mt_rand(1, 999) . pathinfo($file['name'])['basename'];
          $posterTo = $this->posterDir . '/' . $posterTemp;
          if (move_uploaded_file($file['tmp_name'], $posterTo)) {
            $savePath['poster'] = [
              'path' => $posterTo,
              'size' => $file['size'],
              'name' => $file['name'],
              'poster' => 'http://localhost:8888/videos/posters/' . $this->username . '/' . $posterTemp
            ];
          }
        } else {
          $sourceTemp = mt_rand(1, 999) . pathinfo($file['name'])['basename'];
          $sourceTo = $this->sourceDir . '/' . $sourceTemp;
          if (move_uploaded_file($file['tmp_name'], $sourceTo)) {
            $savePath['source'] = [
              'path' => $sourceTo,
              'size' => $file['size'],
              'name' => $file['name'],
              'source' => 'http://localhost:8888/videos/source/' . $this->username . '/' . $sourceTemp
            ];
          }
        }
      }
    }
    return $savePath;
  }

  protected function makeDir()
  {
    // 创建视频封面以及资源的文件夹
    $this->posterDir = $posterPath = '/Users/ame/code/graduation/app/videos/posters/' . $this->username;
    $this->sourceDir = $sourcePath = '/Users/ame/code/graduation/app/videos/source/' . $this->username;
    $poster_status = is_dir($posterPath) or mkdir($posterPath, 0775, true);
    $source_status = is_dir($sourcePath) or mkdir($sourcePath, 0775, true);
    return $poster_status and $source_status;
  }

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
