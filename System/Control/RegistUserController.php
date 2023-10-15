<?php
require_once '../Model/UserModel.php';

class RegistUserController {
    public function registerUser() {
        // POSTリクエストを処理
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $existingUser = $userModel->getUserByEmail($email);

            if ($existingUser) {
                include '../Views/RegistUser.php';
            } else {
                // ユーザーを登録
                $userModel->createUser($name, $email, $password);
                include '../Views/Login.php';
                // 登録成功の処理やリダイレクト
            }
        }
    }
}
?>
    
