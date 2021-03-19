<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

use App\Bbs;

include '../../Bbs/Bbs.php';
include '../../DB/DB.php';

$bbs = new Bbs\Bbs;

echo json_encode($bbs->getArticle($_GET['article_id']));
