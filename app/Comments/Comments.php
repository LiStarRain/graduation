<?php

namespace App\Comments;

use \App\DB;

@include '../DB/DB.php';

class Comments
{
  // 发表评论
  public function publishComment(array $comment_info)
  {
    $db = new DB\DB;
    $sql = "INSERT comments(author_id,article_id,content) 
    VALUES (:author_id, :article_id, :content)";
    $vars = [
      'author_id' => $comment_info['author_id'],
      'article_id' => $comment_info['article_id'],
      'content' => $comment_info['content']
    ];
    return $db->insert($sql, $vars);
  }

  // 获取文章评论
  public function getComments(int $article_id): array
  {
    $db = new DB\DB;
    $sql = "SELECT ac.username, ui.head_img, c.publish_time, c.content, c.id FROM comments AS c
    INNER JOIN article AS a
    INNER JOIN account AS ac
    INNER JOIN user_info AS ui
    WHERE c.author_id = ac.id
    AND ac.id = ui.user_id 
    AND c.article_id = a.id
    AND a.id = :article_id
    ORDER BY c.publish_time DESC;";
    $vars = ['article_id' => $article_id];
    return $this->format($db->query($sql, $vars));
  }

  // 格式化评论
  protected function format(array $res): array
  {
    $result = [];
    foreach ($res as $field) {
      $result[] = [
        'comment_id' => $field['id'],
        'user' => [
          'username' => $field['username'],
          'head_img' => $field['head_img']
        ],
        'content' => [
          'text' => $field['content'],
          'publish_time' => $this->formatTime($field['publish_time'])
        ]
      ];
    }
    return $result;
  }

  // 格式化时间
  protected function formatTime(string $time)
  {
    date_default_timezone_set("PRC");
    $res = '';
    $diff = floor((strtotime('NOW') - strtotime($time)) / 60);
    if ($diff < 60) {
      if ($diff === 0) {
        $res = "刚刚";
      } else {
        $res = "{$diff}分钟前";
      }
    } else {
      $diff = floor($diff / 60);
      if ($diff < 24) {
        $res = "{$diff}小时前";
      } elseif ($diff >= 24 and $diff <= 24 * 30) {
        $diff = floor($diff / 24);
        $res = "{$diff}天前";
      } else {
        $diff = floor($diff / (24 * 30));
        $res = "{$diff}个月前";
      }
    }
    return $res;
  }
}
