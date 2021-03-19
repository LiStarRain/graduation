<?php

namespace App\Bbs;

use \App\DB;

@include '../DB/DB.php';

class Bbs
{
  // 存储文章信息
  public function publish_article(array $article)
  {
    $db = new DB\DB;
    $sql = "INSERT article(author_id, title, content) 
      VALUES (:author_id, :title, :content)";
    $vars = [
      "author_id" => $article['author_id'],
      "title" => $article['title'],
      "content" => $article['content']
    ];
    return $db->insert($sql, $vars);
  }

  // 获取文章列表
  public function getArticleList(int $page)
  {
    // 默认一次获取15条
    $counts = 15;
    $startIndex = $page * $counts;
    $db = new DB\DB;
    $sql = "SELECT ac.username,ui.head_img,a.title,a.id,a.publish_time,a.top FROM article AS a
    INNER JOIN account AS ac
    INNER JOIN user_info AS ui
    WHERE a.author_id = ac.id
    AND ac.id = ui.user_id
    ORDER BY a.top DESC, a.publish_time DESC
    LIMIT {$startIndex}, {$counts};";
    $res = $this->getTime($db->query($sql));
    return $res;
  }

  // 获取某个用户发表过的所有文章
  public function getUserArticles(int $user_id)
  {
    $db = new DB\DB;
    $sql = "SELECT id,content,title,publish_time FROM article 
    WHERE author_id = :id
    ORDER BY publish_time DESC;";
    return $this->getTime($db->query($sql, ['id' => $user_id]));
  }

  // 格式化时间
  protected function getTime(array $res)
  {
    date_default_timezone_set("PRC");
    $result = [];
    foreach ($res as $field) {
      $diff = floor((strtotime('NOW') - strtotime($field['publish_time'])) / 60);
      if ($diff < 60) {
        if ($diff === 0) {
          $field['publish_time'] = "刚刚";
        } else {
          $field['publish_time'] = "{$diff}分钟前";
        }
      } else {
        $diff = floor($diff / 60);
        if ($diff < 24) {
          $field['publish_time'] = "{$diff}小时前";
        } elseif ($diff >= 24 and $diff <= 24 * 30) {
          $diff = floor($diff / 24);
          $field['publish_time'] = "{$diff}天前";
        } else {
          $diff = floor($diff / (24 * 30));
          $field['publish_time'] = "{$diff}个月前";
        }
      }
      $result[] = $field;
    }
    return $result;
  }

  // 获取总页数
  public function getPages()
  {
    $db = new DB\DB;
    $sql = "SELECT count(*) AS pages FROM article;";
    return ceil($db->query($sql)[0]['pages'] / 15);
  }

  // 获取文章信息
  public function getArticle($article_id)
  {
    $db = new DB\DB;
    $sql = "SELECT ac.username,ui.head_img,a.title,a.content,a.publish_time FROM article AS a
    INNER JOIN account AS ac
    INNER JOIN user_info AS ui
    WHERE a.author_id = ac.id
    AND ac.id = ui.user_id
    AND a.id = :id";
    $res = $db->query($sql, ['id' => $article_id]);
    return $this->getTime($res)[0];
  }

  // 获取搜索框查询信息
  public function getSearchResult(string $keywords)
  {
    $db = new DB\DB;
    $sql = "SELECT id,title FROM article WHERE title LIKE :keywords;";
    $res = $db->query($sql, ['keywords' => "%{$keywords}%"]);
    return $res;
  }

  public function deleteUserArticle(int $article_id)
  {
    $db = new DB\DB;
    $sql = "DELETE FROM article WHERE id = :id";
    return $db->execute($sql, ['id' => $article_id]);
  }
}
