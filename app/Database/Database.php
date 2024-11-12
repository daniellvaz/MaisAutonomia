<?php

namespace MaisAutonomia\Database;

use PDO;

class Database
{

  private PDO $connection;

  public function __construct()
  {
    $this->connection = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4", $_ENV['DB_USER'], $_ENV['DB_PASS']);
  }

  public function query(): PDO
  {
    return $this->connection;
  }
}
