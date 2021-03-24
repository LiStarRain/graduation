<?php

use \App\Thumb;

include './Thumb.php';

$thumb = new Thumb\Thumb;
$path = '../Water/water.png';
$thumb->make($path, $path, 300, 300);
