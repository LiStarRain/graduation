<?php

namespace App\DB;

use \PDO;

class DB
{
  // 最后一次插入的自增主键
  public $lastInsertId = null;
  // 配置项
  protected $config;
  // PDO数据库资源对象
  protected $link = null;
  public function __construct(array $config = null)
  {
    // 初始化连接配置
    $this->config = is_null($config) ? [
      'host' => '127.0.0.1:8889',
      'user' => 'ame',
      'password' => 'ame990430',
      'database' => 'acoustic',
      'charset' => 'utf8'
    ] : $config;
    // 连接数据库
    $this->connect();
  }

  // 连接数据库
  public function connect()
  {
    $dsn = sprintf(
      "mysql:host=%s;dbname=%s;charset=%s",
      $this->config['host'],
      $this->config['database'],
      $this->config['charset']
    );
    $this->link = $this->link ? $this->link : new PDO($dsn, $this->config['user'], $this->config['password']);
    // 设置错误处理模式
    $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // 设置返回数组类型默认为关联数组
    $this->link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // 属性名强制小写
    $this->link->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
    return $this->link;
  }

  // 执行删改语句
  public function execute(string $sql, array $vars = null)
  {
    try {
      // 开启事务
      $this->link->beginTransaction();
      $sth = $this->link->prepare($sql);
      $sth->execute($vars);
      // 提交事务
      $this->link->commit();
      return 1;
    } catch (\PDOException $e) {
      // 事务回滚
      $this->link->rollback();
      die($e->getMessage());
    }
  }

  // 查询操作
  public function query(string $sql, array $vars = null)
  {
    try {
      $sth = $this->link->prepare($sql);
      $sth->execute($vars);
      $res = $sth->fetchAll();
      return $res;
    } catch (\PDOException $e) {
      die(0);
    }
  }

  // 插入操作
  public function insert(string $sql, array $vars)
  {
    try {
      $this->link->beginTransaction();
      $sth = $this->link->prepare($sql);
      $sth->execute($vars);
      $this->lastInsertId = $this->link->lastInsertId();
      $this->link->commit();
      return 1;
    } catch (\PDOException $e) {
      $this->link->rollback();
      die(0);
    }
  }
}
