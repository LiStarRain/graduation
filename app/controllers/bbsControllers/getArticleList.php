<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

use App\Bbs;

include '../../DB/DB.php';
include '../../Bbs/Bbs.php';

$page = $_GET['page'];
$bbs = new Bbs\Bbs;
$res = json_encode($bbs->getArticleList($page));
echo $res;
