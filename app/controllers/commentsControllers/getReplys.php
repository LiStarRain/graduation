<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

use \App\Reply;

@include '../../DB/DB.php';
@include '../../Reply/Reply.php';

$reply = new Reply\Reply;
echo json_encode($reply->getReply((int)$_GET['commentId']));
