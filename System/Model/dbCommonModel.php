<?php
$rootPath = __DIR__ . '/..';
// echo __DIR__ //この行のコメントアウトでルートを確認
require_once $rootPath . '/define.php';

class dbCommonModel {
    
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
