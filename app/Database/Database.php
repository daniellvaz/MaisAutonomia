<?php

namespace MaisAutonomia\Database;

use PDO;

class Database
{

  private PDO $connection;

  public function __construct()
  {
    $this->connection = new PDO("mysql:host=localhost;dbname={$_ENV['DB_NAME']};charset=utf8mb4", $_ENV['DB_NAME'], $_ENV['DB_PASS']);
  }

  public function query(string $query, array $params): PDO
  {
    return $this->connection;
  }
}
