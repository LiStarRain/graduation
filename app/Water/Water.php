<?php

namespace App\Water;

use Exception;

// 水印处理
class Water
{
  // 水印图资源
  protected $water;
  public function __construct(string $water = '/Users/ame/code/graduation/app/Water/water.png')
  {
    $this->water = $water;
  }

  public function make(string $image, string $filename = null, int $pos = 3)
  {
    // 检测目标文件是否是合法的图片文件
    $this->checkImage($image);
    // 获取图片的GD资源
    $res = $this->getResource($image);
    $water = $this->getResource($this->water);
    // 获取水印的位置
    $pos = $this->getPosition($res, $water, $pos);
    // 添加水印
    imagecopy($res, $water, $pos['x'], $pos['y'], 0, 0, imagesx($water), imagesy($water));
    // 生成新的图像
    return $this->showAction($image)($res, $filename);
  }

  // 检查文件合法性
  protected function checkImage(string $image)
  {
    if (!is_file($image) || !getimagesize($image)) {
      throw new Exception('File is not image');
    }
  }

  // 获取图片资源
  protected function getResource(string $image)
  {
    $info = getimagesize($image);
    $functions = [
      1 => 'imagecreatefromgif',
      2 => 'imagecreatefromjpeg',
      3 => 'imagecreatefrompng'
    ];
    $call = $functions[$info[2]];
    return $call($image);
  }

  // 获取水印的坐标位置
  protected function getPosition($res, $water, int $pos)
  {
    $info = ['x' => 0, 'y' => 0];
    switch ($pos) {
      case 1:
        break;
      case 2:
        $info['x'] = (imagesx($res) - imagesx($water)) / 2;
        break;
      case 3:
        $info['x'] = imagesx($res) - imagesx($water);
        break;
      case 4:
        $info['y'] = (imagesy($res) - imagesy($water)) / 2;
        break;
      case 5:
        $info['x'] = (imagesx($res) - imagesx($water)) / 2;
        $info['y'] = (imagesx($res) - imagesy($water)) / 2;
        break;
      case 6:
        $info['x'] = imagesx($res) - imagesx($water);
        $info['y'] = (imagesy($res) - imagesy($water)) / 2;
        break;
      case 7:
        $info['y'] = imagesy($res) - imagesy($water);
        break;
      case 8:
        $info['x'] = (imagesx($res) - imagesx($water)) / 2;
        $info['y'] = imagesy($res) - imagesy($water);
        break;
      case 9:
        $info['x'] = imagesx($res) - imagesx($water);
        $info['y'] = imagesy($res) - imagesy($water);
    }
    return $info;
  }

  // 显示图像
  protected function showAction(string $image)
  {
    $info = getimagesize($image);
    $functions = [
      1 => 'imagegif',
      2 => 'imagejpeg',
      3 => 'imagepng'
    ];
    return $functions[$info[2]];
  }
}
