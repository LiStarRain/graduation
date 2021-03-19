<?php

use \App\Thumb;

include './Thumb.php';

$thumb = new Thumb\Thumb;
$path = '../files/2021/02/1614488658398.jpg';
$thumb->make($path, $path, 50, 50);
