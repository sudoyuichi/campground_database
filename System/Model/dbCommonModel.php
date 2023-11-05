<?php
$rootPath = __DIR__ . '/..';
// echo __DIR__ //この行のコメントアウトでルートを確認
require_once $rootPath . '/define.php';

class dbCommonModel {
    
    private $connection;

    public function __construct() {
        try {
            $this->connection = new PDO("mysql:host=". DB_HOST . ";dbname=". DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           # echo "データベース接続に成功";
        }catch (PDOException $e) {
           # echo 'DB接続エラー: ' . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
