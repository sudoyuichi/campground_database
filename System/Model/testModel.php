<?php
require_once 'dbCommonModel.php';

class testModel {

    private $db;

    public function __construct() {
        $this->db = new dbCommonModel();
    }

    public function getTest() {
        $connection = $this->db->getConnection();
        // ここに接続テストのロジックを書く

        // サンプルとして、DBのステータスを返します。
        return $connection->stat();
    }
}
