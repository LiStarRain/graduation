<?php

namespace App\Reply;

use \App\DB;

@include '../DB/DB.php';

class Reply
{
  // 回复评论
  public function postReply(array $replyInfo)
  {
    $db = new DB\DB;
    $sql = "INSERT replys(from_user_id, to_user_id, comment_id, content)
      VALUES(:from_user_id, :to_user_id, :comment_id, :content)";
    $vars = [
      'from_user_id' => $replyInfo['from_user_id'],
      'to_user_id' => $replyInfo['to_user_id'],
      'comment_id' => $replyInfo['comment_id'],
      'content' => $replyInfo['content']
    ];
    return $db->insert($sql, $vars);
  }

  // 获取回复
  public function getReply(int $comment_id)
  {
    $db = new DB\DB;
    $sql1 = "SELECT a.username,r.content,ui.head_img FROM replys AS r
    INNER JOIN account AS a
    INNER JOIN user_info AS ui
    INNER JOIN comments AS c
    WHERE r.from_user_id = a.id 
    AND a.id = ui.user_id
    AND c.id = r.comment_id
    AND c.id = :comment_id;";
    $vars1 = ['comment_id' => $comment_id];
    $from = $db->query($sql1, $vars1);

    $sql2 = "SELECT a.username FROM replys AS r
    INNER JOIN account AS a
    INNER JOIN user_info AS ui
    INNER JOIN comments AS c
    WHERE r.to_user_id = a.id 
    AND a.id = ui.user_id
    AND c.id = r.comment_id
    AND c.id = :comment_id;";
    $to = $db->query($sql2, $vars1);

    $res = [];
    foreach ($from as $key => $field) {
      $res[] = [
        'from_username' => $field['username'],
        'head_img' => $field['head_img'],
        'to_username' => $to[$key]['username'],
        'content' => $field['content']
      ];
    }
    return $res;
  }

  // 获取用户的回复
  public function getUserReplys(int $user_id)
  {
    $db = new DB\DB;
    $sql = "SELECT a.username,r.content,ac.id,ui.head_img FROM replys AS r
    INNER JOIN account AS a
    INNER JOIN user_info AS ui
    INNER JOIN comments AS c
    INNER JOIN article as ac
    WHERE r.from_user_id = a.id 
    AND a.id = ui.user_id
    AND c.id = r.comment_id
    AND c.article_id = ac.id
    AND r.to_user_id = :user_id
    ORDER BY r.publish_time DESC;";
    $vars = ['user_id' => $user_id];
    return $db->query($sql, $vars);
  }
}
