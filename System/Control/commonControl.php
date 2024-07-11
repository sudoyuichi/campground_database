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
     * セッションが正しいかの認証を行う
     *
     * @return bool 認証が成功した場合は true、失敗した場合は false
     */
    public function authenticateSession() {
        if (isset($_SESSION) && $_SESSION['isLogin']) {
            return true;
        }
        return false;
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
     * 利用規約、プライバシーポリシーへの同意とユーザ詳細登録の進捗状況
     * セッションデータへ保存
     * 
     * @param userDetailModel $userDetailModel userDetailModelクラスのインスタンス。
     *                                         user_detailsテーブルとのDB接続に利用。
     */
    public function verifyRegistrationProgress($userDetailModel){
        # user_idを条件にuser_detailsテーブルからデータ取得
        $_SESSION['user_data'] = $userDetailModel->getUserDetailFromUserId($_SESSION['user_id']);
        if ($_SESSION['user_data'] !== null){
            if ($_SESSION['user_data']['privacy_policy_agreed'] >= CommonControl::LATEST_PRIVACY_POLICY){
                $_SESSION['privacyPolicy'] = true;
            }
            if ($_SESSION['user_data']['terms_of_service_agreed'] >= CommonControl::LATEST_TERMS_OF_SERVICE){
                $_SESSION['termsOfService'] = true;
            }
            if ($_SESSION['user_data']['nick_name'] !== null){
                $_SESSION['completedToUserDetailRegistration'] = true;
            }
        }
    }

    /**
     * 入力された文字のエスケープ処理を行います。
     * 
     * @param string $input 入力されたデータ
     */
    public function sanitizeInput($input) {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    /**
     * 入力された配列データののエスケープ処理を行います。
     * 
     * @param array $array 配列データ
     */
    public function sanitizeArray($array) {
        foreach ($array as $key => $value) {
            # 多次元配列の場合は再度このメソッドを呼び出しエスケープ処理します。
            if (is_array($value)) {
                $array[$key] = $this->sanitizeArray($value);
            } else {
                $array[$key] = $this->sanitizeInput($value);
            }
        }
        return $array;
    }
}
