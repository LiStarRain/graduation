<?php

use \App\Water;

include './Water.php';

$water = new Water\Water('./water.png');
$water->make('../files/2021/02/1614170094486.jpg', './test.jpg');
