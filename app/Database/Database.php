<?php

namespace MaisAutonomia\Database;

use PDO;

class Database
{

  private PDO $connection;

  public function __construct()
  {
    $this->connection = new PDO("mysql:host=127.0.0.1;dbname={$_ENV['DB_NAME']};charset=utf8mb4", $_ENV['DB_USER'], $_ENV['DB_PASS']);
  }

  public function query(): PDO
  {
    return $this->connection;
  }
}
