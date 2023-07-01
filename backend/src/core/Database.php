<?php

namespace Aruka\Core;

use PDO;
use PDOException;

class Database
{
  private $host = DB_HOST;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $dbname = DB_NAME;

  private $handler;
  private $error;

  private $statement;

  public function __construct()
  {
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
    $options = [
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    try {
      $this->handler = new PDO($dsn, $this->user, $this->pass, $options);
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
    }
  }
}
