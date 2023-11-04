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
        $query = "SELECT * FROM users ";
    
        // クエリを実行
        $result = $connection->query($query);
    
        if ($result) {
            // 結果セットを格納する空の配列
            $users = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                // 行を配列に追加
                $users[] = $row;
            }
            return $users;
        }
        return $connection->errorInfo();
    }
}
