<?php

use App\DB;

@include '../../DB/DB.php';
@include '../../User/User.php';

header('Access-Control-Allow-origin: *');
header('Content-type: application/json');

$db = new DB\DB;

$get_path = "SELECT poster,src FROM videos WHERE id = :id";
$path = $db->query($get_path, ['id' => $_POST['id']])[0];

$poster_path = preg_replace('/^https?:\/\/localhost:8888\//', '../../', $path['poster']);
$src_path = preg_replace('/^https?:\/\/localhost:8888\//', '../../', $path['src']);
if (is_file($poster_path)) {
  $deletePosterStatus = unlink($poster_path);
  $deleteSrcStatus = unlink($src_path);
}
$sql = "DELETE FROM videos WHERE id = :id";
$dbStatus = $db->execute($sql, ['id' => $_POST['id']]);
echo json_encode($deletePosterStatus && $deleteSrcStatus && $dbStatus);
