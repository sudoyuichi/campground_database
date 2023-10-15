<?php
class UserModel {
    private $db;

    public function __construct() {
        // データベースへの接続を初期化
        try {
            $this->db = new PDO('mysql:dbname=TestDB;host=localhost;charset=utf8','root','root');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "データベース接続に成功";
        }catch (PDOException $e) {
            echo 'DB接続エラー: ' . $e->getMessage();
        }
    }

    public function getUserByEmail($email) {
        $query = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($name, $email, $password) {
        try{
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $query = $this->db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $hash);
            $query->execute();
            echo "ユーザーが登録されました";
            $this->db->commit();
        } catch (PDOException $e) {
            echo "SQL Error: " . $e->getMessage();
            $this->db->rollBack();
        }    
    }

    public function verifyPassword($email, $password) {
        $user = $this->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}
?>
