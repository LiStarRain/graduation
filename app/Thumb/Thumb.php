<?php

namespace App\Thumb;

class Thumb
{
  public function make(string $image, string $to, int $width, int $height, int $type = 3)
  {
    // 文件检测
    $this->checkImage($image);
    // 获取图片资源
    $image_res = $this->getResource($image);
    // 计算画布的宽高
    $size = $this->getSize($width, $height, imagesx($image_res), imagesy($image_res), $type);
    // 生成画布资源
    $res = imagecreatetruecolor($size['width'], $size['height']);
    // 裁切图片
    imagecopyresampled(
      $res,
      $image_res,
      0,
      0,
      0,
      0,
      $size['width'],
      $size['height'],
      $size['image_width'],
      $size['image_height']
    );
    // 获得图片显示函数
    $call = $this->showAction($image);
    // 保存图片
    return $call($res, $to);
  }

  // 图片文件检测
  protected function checkImage(string $image)
  {
    if (!is_file($image) || !getImageSize($image)) {
      throw new \Exception('File is not a image');
    }
  }

  // 获取图片资源
  protected function getResource(string $image)
  {
    $info = getimagesize($image);
    $functions = [
      1 => "imagecreatefromgif",
      2 => "imagecreatefromjpeg",
      3 => "imagecreatefrompng"
    ];
    $call = $functions[$info[2]];
    return $call($image);
  }

  // 计算画布宽高
  protected function getSize(int $width, int $height, int $image_width, int $image_height, int $type)
  {
    switch ($type) {
      case 1:
        // 保存宽度，高度自动，调整画布
        $height = $width / $image_width * $image_height;
        break;
      case 2:
        // 保存高度，宽度自动，调整画布
        $width = $height / $image_height * $image_width;
        break;
      case 3:
      default:
        // 自适应画布尺寸，调整图像
        if ($image_height / $height > $image_width / $width) {
          // 裁减高度
          $image_height = $image_width / $width * $height;
        } else {
          // 裁减宽度
          $image_width = $image_height / $height * $width;
        }
    }
    return [
      "width" => $width,
      "height" => $height,
      "image_width" => $image_width,
      "image_height" => $image_height
    ];
  }

  // 获得图片显示函数
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
