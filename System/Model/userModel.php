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
     * @param string $uuid リセットトークン
     * @param string $timeLimit リセットトークン有効期限
     * 
     * @return void
     */
    public function createUser($name, $email, $hash, $uuid, $timeLimit) {
        $returnVal = false;
        try{
            $this->connection->beginTransaction();
            # DBへとユーザ登録するクエリ
            $query = $this->connection->prepare('INSERT INTO 
            users (name, email, password, password_reset_token, password_reset_expiration) 
            VALUES (:name, :email, :password, :password_reset_token, :password_reset_expiration)');
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $hash);
            $query->bindParam(':password_reset_token', $uuid);
            $query->bindParam(':password_reset_expiration', $timeLimit);
            $query->execute();
            $this->connection->commit();
            $returnVal = true;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] != 1062) {
                // 1062は一意制約違反を示すエラーコードです
                $returnVal = false;
            }
            $this->connection->rollBack();
        }
        return $returnVal;
    }

    /**
     * メールアドレスがDBに存在するかの確認用メソッド
     *
     * 与えられたメルアドを条件にDBからデータを取得し
     * 取得したデータを返す。
     *
     * @param string $email メールアドレス
     * @return array|false データ取得できた場合はデータ配列
     */
    public function getUserByEmail($email) {
        $query = $this->connection->prepare('SELECT * FROM users WHERE email = :email');
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * パスワード認証を行うメソッド
     *
     * @param string $email メールアドレス
     * @param string $password パスワード
     * @return bool　認証に成功したらtrue
     */
    public function verifyPassword($email, $password) {
        # アドレスでユーザデータを取得
        $user = $this->getUserByEmail($email);
        # ユーザが存在し、かつハッシュ化されたパスワードが正しい場合
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['name'] = $user['name'];
            session_regenerate_id();
            return true;
        }else{
            return false;
        }
    }
}
