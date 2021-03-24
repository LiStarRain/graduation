<?php

use App\DB;

include '../../DB/DB.php';

header('Access-Control-Allow-origin: *');
header('Content-type: application/json');


$db = new DB\DB();
$count = 12;
$sql = "SELECT username,head_img,poster,`desc`,src,tag,v.id
        FROM videos AS v
        INNER JOIN account AS a
        INNER JOIN user_info as ui 
        WHERE FIND_IN_SET(:tag, tag)
        AND v.author_id = a.id 
        AND a.id = ui.user_id
        ORDER BY v.update_time DESC
        LIMIT {$_GET['startIndex']},{$count}";
$res = $db->query($sql, ['tag' => $_GET['tag']]);
// 格式化数据
$data = [];
foreach ($res as $video) {
  $data[] = [
    'id' => $video['id'],
    'poster' => $video['poster'],
    'desc' => $video['desc'],
    'tag' => $video['tag'],
    'src' => $video['src'],
    "author" => [
      'name' => $video['username'],
      'head_img' => $video['head_img']
    ]
  ];
}
echo json_encode($data);
