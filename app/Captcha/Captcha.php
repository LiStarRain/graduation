<?php

namespace App\Captcha;

// 验证码类
class Captcha
{
  // 验证码宽度
  protected $width;
  // 验证码高度
  protected $height;
  // 验证码位数
  protected $len;
  // 验证码字体大小
  protected $size;
  // 最终生成的验证码
  protected $code;
  // 验证码图片资源
  protected $resource;

  public function __construct(int $width = 150, int $height = 50, int $len = 4, int $size = 20)
  {
    // 初始化
    $this->width = $width;
    $this->height = $height;
    $this->len = $len;
    $this->size = $size;
    $this->code = '';
  }

  public function make()
  {
    // 生成画布
    $this->resource = imagecreatetruecolor($this->width, $this->height);
    // 设置背景填充颜色
    $background = imagecolorallocate($this->resource, 150, 150, 150);
    imagefill($this->resource, 0, 0, $background);
    // 绘制文本
    $this->text();
    // 绘制干扰线条
    $this->line();
    // 绘制干扰点
    $this->point();
    // 将验证码返回
    $this->show();
    return $this->code;
  }

  // 绘制文本
  protected function text()
  {
    // 加载字体
    $font = realpath('./source.otf');
    // 字体文本
    $text = 'abcdefghijklmnopqrstuvwxyz1234567890';
    for ($i = 0; $i < $this->len; $i++) {
      // 随机大小写
      $char = mt_rand(0, 1) ? $text[mt_rand(0, strlen($text) - 1)] : strtoupper($text[mt_rand(0, strlen($text) - 1)]);
      // 将验证码信息保存
      $this->code .= $char;
      // 字符的x坐标
      $x = $this->width / $this->len;
      // 角度
      $angle = mt_rand(-30, 30);
      // 看一下字符高度
      $box = imagettfbbox($this->size, $angle, $font, $char);
      // 把字符放在正中间
      $y = $this->height / 2 - ($box[7] - $box[1]) / 2;
      // 获取文本颜色
      $textColor = $this->color();
      // 绘画文本
      imagettftext($this->resource, $this->size, $angle, $x * $i + 10, $y, $textColor, $font, $char);
    }
  }

  // 随即获取文本颜色
  protected function color()
  {
    return imagecolorallocate($this->resource, mt_rand(0, 150), mt_rand(0, 100), mt_rand(0, 100));
  }

  // 绘制干扰线条
  protected function line()
  {
    for ($i = 0; $i < 6; $i++) {
      // 设置线条的粗细
      imagesetthickness($this->resource, mt_rand(1, 2));
      imageline(
        $this->resource,
        mt_rand(0, $this->width),
        mt_rand(0, $this->height),
        mt_rand(0, $this->width),
        mt_rand(0, $this->height),
        $this->color()
      );
    }
  }

  // 绘制干扰点
  protected function point()
  {
    for ($i = 0; $i < 333; $i++) {
      imagesetpixel(
        $this->resource,
        mt_rand(0, $this->width),
        mt_rand(0, $this->height),
        $this->color()
      );
    }
  }

  // 返回资源
  protected function show()
  {
    header('Content-type: image/png');
    imagepng($this->resource);
  }
}
