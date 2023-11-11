<?php
require_once 'dbCommonModel.php';

class userModel {

    private $db;
private $connection;

    public function __construct() {
        $this->db = new dbCommonModel();
            $this->connection = $this->db->getConnection();
    }

    /**
     * ユーザーをデータベースに登録するメソッド
     *
     * このメソッドは、与えられたユーザー情報をデータベースに登録します。
     * ユーザー名、メールアドレス、およびパスワードのハッシュを受け取り、
     * データベースの "users" テーブルに新しいユーザーレコードを挿入します。
     *
     * @param string $name ユーザー名
     * @param string $email メールアドレス
     * @param string $password パスワード
     *
     * @return void
     */
    public function createUser($name, $email, $password) {
        $msg = '';
        try{
            $this->connection->beginTransaction();
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $query = $this->connection->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $hash);
            $query->execute();
            $this->connection->commit();
            $msg = "ユーザーが登録されました";
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // 1062は一意制約違反を示すエラーコードです
                $msg = "このメールアドレスは既に登録されています。";
            } else {
                // その他のデータベース関連のエラーを処理
                $msg = "データベースエラー: " . $e->getMessage();
            }
            $this->connection->rollBack();
        }
        echo $msg;
    }

    public function getUserByEmail($email) {
        $query = $this->connection->prepare('SELECT * FROM users WHERE email = :email');
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function verifyPassword($email, $password) {
        $user = $this->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}
