<?php

use App\DB;

@include '../../DB/DB.php';

header('Access-Control-Allow-origin: *');
header('Content-type: application/json');


$db = new DB\DB;
$sql = "DELETE FROM comments where id = :id";
echo json_encode($db->execute($sql, ['id' => $_POST['id']]));
