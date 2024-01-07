<?php

$rootPath = __DIR__ . '/..';

require_once $rootPath . '/define.php';
require_once $rootPath . MODEL_PATH . '/userModel.php';
require_once $rootPath . VIEW_PATH . '/vendor/smarty/smarty/libs/Smarty.class.php';

class CommonControl extends Smarty {

    // プライバシポリシーまたは利用規約の最新更新日を定義
    const LATEST_PRIVACY_POLICY = '2024-01-01';
    const LATEST_TERMS_OF_SERVICE = '2024-01-01';
    
    public function __construct() {
        // 日本のタイムゾーンを設定
        date_default_timezone_set('Asia/Tokyo');
        session_start();
        # 画面にエラーを表示させるかの設定。
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        // 本番は↓に切り替える事でエラー内容を画面に非表示できる。
        // error_reporting(0);
        // ini_set('display_errors', 0);
    }
    
    /**
     * UUIDを生成
     * 
     */
    public function generateUUID() {
        // Generate 16 bytes (128 bits) of random data
        $data = random_bytes(16);
        
        // Set the version to 4 (random) and the variant to 1
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Convert the binary data to a hexadecimal string and remove the hyphens
        return str_replace('-', '', vsprintf('%s%s%s%s%s', str_split(bin2hex($data), 4)));
    }

    /**
     * uuidが有効期限内であるかを確認
     *
     * @param array $userData uuidで取得したユーザデータ
     * @return bool $isUuidStillAlive uuidが有効期限内かの判定結果
     */
    public function checkUuidStillValid($userData) {
        $now = date('Y-m-d H:i:s');
        $isUuidStillAlive = False;
        # データが取れた場合
        if($userData){
            $expirationLimit = $userData['password_reset_expiration'];
            # 現在が発行期限内であるかを確認
            if($now <= $expirationLimit){
                $isUuidStillAlive = true;
            }
        }
        return $isUuidStillAlive;
    }

    /**
     * パスワード認証を行う
     *
     * @param string $email メールアドレス
     * @param string $password パスワード
     * @param userModel $userModel userModelクラスのインスタンス
     * @return bool　認証に成功したらtrue
     */
    public function verifyPassword($email, $password, $userModel) {
        try{
            # アドレスでユーザデータを取得
            $user = $userModel->getUserByEmail($email);
            # 取得したユーザステータスが1、かつハッシュ化されたパスワードが正しい場合
            if ($user && $user['registration_status'] == 1 && password_verify($password, $user['password'])) {
                session_regenerate_id();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['isLogin'] = true;
                $_SESSION['privacyPolicy'] = false;
                $_SESSION['termsOfService'] = false;
                $_SESSION['completedToUserDetailRegistration'] = false;
                $_SESSION['nick_name'] = null;
                return true;
            }
        }catch (Exception $e){
            error_log('ログイン認証に失敗しました。: ' . $e->getMessage());
            return false;
        }
        return false;
    }

    /**
     * 利用規約、プライバシーポリシーへの同意とユーザ詳細登録の進捗状況
     * セッションデータへ保存
     * 
     * @param userDetailModel $userDetailModel userDetailModelクラスのインスタンス。
     *                                         user_detailsテーブルとのDB接続に利用。
     */
    public function verifyRegistrationProgress($userDetailModel){
        # user_idを条件にuser_detailsテーブルからデータ取得
        $progressData = $userDetailModel->getRegistrationProgress($_SESSION['user_id']);
        if ($progressData != null){
            if ($progressData['privacy_policy_agreed'] >= CommonControl::LATEST_PRIVACY_POLICY){
                $_SESSION['privacyPolicy'] = true;
            }
            if ($progressData['terms_of_service_agreed'] >= CommonControl::LATEST_TERMS_OF_SERVICE){
                $_SESSION['termsOfService'] = true;
            }
            if ($progressData['nick_name']){
                $_SESSION['completedToUserDetailRegistration'] = true;
                $_SESSION['nick_name'] = $progressData['nick_name'];
            }
        }
    }

    /**
     * セッションを廃棄しログアウト
     * 
     * ログインページへ遷移
     */
    public function logout(){
        session_destroy();
    }
}
