<?php
$file = $_GET['src'];

// 下载图片
header('Access-Control-Allow-Origin: *');

// 指定下载文件类型为二进制
header('Content-type: application/octet-stream');
// 获取文件名
$fileName = basename($file_name);

// 下载窗口显示文件名
header("Content-Disposition:attachment;filename={$fileName}");

// 文件尺寸单位
header('Accept-range:bytes');

// 文件大小
header('Accept-length:' . filesize($file));

// 读取文件内容来下载
readfile($file);
