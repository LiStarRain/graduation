<?php
// 获取Glance页面展示的图片数据
use App\DB;

include '../../DB/DB.php';

header('Access-Control-Allow-origin: *');
header('Content-type: application/json');


$db = new DB\DB();
$count = 12;
$sql = "SELECT img,`desc`,tag,username,head_img FROM glance_images AS gi
        INNER JOIN account AS a
        INNER JOIN user_info AS ui
        WHERE FIND_IN_SET(:tag, tag)
        AND gi.author_id = a.id
        AND a.id = ui.user_id
        ORDER BY gi.upload_time DESC LIMIT {$_GET['startIndex']},{$count}";
$res = $db->query($sql, ['tag' => $_GET['tag']]);
// 格式化数据
$data = [];
foreach ($res as $image) {
  $data[] = [
    'img' => $image['img'],
    'desc' => $image['desc'],
    'tag' => $image['tag'],
    "author" => [
      'name' => $image['username'],
      'head_img' => $image['head_img']
    ]
  ];
}
echo json_encode($data);
