<?php

$rootPath = __DIR__ . '/..';

require_once $rootPath . '/define.php';
require_once $rootPath . CONTROL_PATH . '/commonControl.php';  // commonControl.phpをインクルード
require_once $rootPath . MODEL_PATH . '/userModel.php';
require_once $rootPath . MODEL_PATH . '/userDetailModel.php';
require_once $rootPath . VIEW_PATH . '/vendor/smarty/smarty/libs/Smarty.class.php';

class authControl extends Smarty {
    const TEMPORARY_REGISTRATION = 0; # 仮登録
    const FULL_REGISTRATION = 1; # 本登録
    const SUSPENDED = 2; # 停止
    const WITHDRAWN = 9; # 退会
    private $rootPath;
    private $common;  // commonControlのインスタンスを保持するプロパティ

    public function __construct() {
        global $rootPath;
        $this->rootPath = $rootPath;
        // commonControlのインスタンスを作成
        $this->common = new commonControl();
        parent::__construct();
        $this->setTemplateDir($this->rootPath . VIEW_PATH . '/templates/');
        $this->setCompileDir($this->rootPath . VIEW_PATH . '/templates_c/');
        $this->setCacheDir($this->rootPath . VIEW_PATH . '/cache/');
        $this->setConfigDir($this->rootPath . VIEW_PATH . '/configs/');
    }

    /**
     * 指定されたモードに基づいて操作を実行し、テンプレートを表示するメソッド
     * mode = registerならユーザ登録処理を実行
     * @param string $mode モード（'index' または 'register'）
     */
    public function execute($mode) {
        $templateDir = 'Auth/';
        $errorMsg = null;
        $timeLimit = '0000-00-00 00:00:00';
        $uuid = null;
        $isUuidStillAlive = null;
        $userModel = new userModel();
        $userDetailModel = new userDetailModel();
        switch ($mode) {
            # ユーザ登録ページ呼び出し
            case 'entry':
                $templateDir .= 'entry.tpl';
                break;
            # ユーザ登録
            case 'register':
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                # メールアドレスが登録済みか確認
                if ($userModel->getUserByEmail($email)){
                    $errorMsg = '既に登録されたアドレスです';
                    $this->assign('result', false);
                    $this->assign('checkUrl', null);
                }else{
                    $hash = password_hash($password, PASSWORD_BCRYPT);
                    //$uuid = パスワドリセットトークンを作成。↓の引数に追加。
                    $uuid = $this->common->generateUUID();
                    $timeLimit = date("Y-m-d H:i:s",strtotime("30 minute"));
                    $userModel->createUser($name, $email, $hash, $uuid, $timeLimit);
                    $errorMsg = 'ユーザーの仮登録が完了しました。';
                    $checkUrl = 'http://'.$_SERVER["HTTP_HOST"].'/campground_database/public/auth.php?mode=check&id='.$uuid;
                    // ↓の方がシンプル？
                    $checkUrl = 'auth.php?mode=check&id='.$uuid;
                    $this->assign('checkUrl', $checkUrl);
                    $this->assign('result', true);
                }
                # ユーザ登録成功画面へ
                $templateDir .= 'showPreRegistrationResult.tpl';
                break;
            # ログイン実行
            case 'login':
                $email = $_POST['email'];
                $password = $_POST['password'];
                # パスワード認証
                $isLoginSuccess = $this->verifyPassword($email, $password, $userModel);
                // ユーザの規約への同意や登録状況に応じて各セッション項目をtrueへ設定
                $this->common->verifyRegistrationProgress($userDetailModel);
                if ($isLoginSuccess){
                    # ログインに成功し、規約への同意・詳細登録まで完了している場合
                    if ($_SESSION['privacyPolicy'] == true && $_SESSION['termsOfService'] == true && $_SESSION['completedToUserDetailRegistration'] == true
                    ) {
                        $_SESSION['isLogin'] = true;
                    }
                    $templateDir = 'Main/';
                    $templateDir .= 'main.tpl';
                    break;
                }
                $errorMsg = 'ログインに失敗しました';
                $templateDir .= 'login.tpl';
                break;
            case 'check':
                $uuid = $_GET['id'];
                # uuidからユーザデータを取得
                $userData = $userModel->getUserDataByUuid($uuid);
                # 取得したユーザデータのuuidの登録期限が期限内かチェック
                $isUuidStillAlive = $this->common->checkUuidStillValid($userData);
                if($isUuidStillAlive){
                    $templateDir .= 'showRegistrationResult.tpl';
                    # 登録ステータスを本登録へ変更
                    $userModel->updateRegistrationStatus($userData['id'], authControl::FULL_REGISTRATION);
                    # ここでユーザ詳細情報テーブルにも新規ユーザを追加
                    $userDetailModel->createUserDetail($userData['id']);
                    break;
                }
                $errorMsg = '本登録出来ませんでした。管理者へお問い合わせをお願い致します。';
                $templateDir .= 'showRegistrationResult.tpl';
                break;
            case 'logout':
                $this->common->logout();
                $templateDir .= 'login.tpl';
                break;
            default:
                $templateDir .= 'login.tpl';
                break;
            }
        $this->assign([
            'errorMsg' => $errorMsg,
            'timeLimit' => date("Y-m-d H:i",strtotime($timeLimit)),
            'id' => $uuid,
            'isUuidStillAlive' => $isUuidStillAlive,
        ]);
        $this->display($templateDir);
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
                $_SESSION['isLogin'] = false;
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
}
