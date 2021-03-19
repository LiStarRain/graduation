<?php
header('Access-Control-Allow-origin: *');
header('Content-type: *');

use \App\Bbs;

include '../../Bbs/Bbs.php';
include '../../DB/DB.php';

$bbs = new Bbs\Bbs;
$keywords = $_GET['keywords'];
echo json_encode($bbs->getSearchResult($keywords));
