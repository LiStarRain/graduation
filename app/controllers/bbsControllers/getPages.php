<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

use App\Bbs;

include '../../DB/DB.php';
include '../../Bbs/Bbs.php';

$bbs = new Bbs\Bbs;
echo json_encode($bbs->getPages());
