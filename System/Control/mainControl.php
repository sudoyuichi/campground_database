<?php

$rootPath = __DIR__ . '/..';

require_once $rootPath . '/define.php';
require_once $rootPath . CONTROL_PATH . '/commonControl.php';  // commonControl.phpをインクルード
require_once $rootPath . MODEL_PATH . '/userModel.php';
require_once $rootPath . VIEW_PATH . '/vendor/smarty/smarty/libs/Smarty.class.php';

class mainControl extends Smarty {

    private $rootPath;
    private $common;  // commonControlのインスタンスを保持するプロパティ

    public function __construct() {
        global $rootPath;
        $this->rootPath = $rootPath;
        // commonControlのインスタンスを作成
        $this->common = new commonControl();
        // セッションのisLoginがFalseならログインページへ戻す
        if(!$this->common->authenticateSession()){
            header('Location: ' .HOST_NAME .'/auth.php');
            exit();
        }
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
        $_POST = $this->common->sanitizeArray($_POST);
        $templateDir = 'Main/';
        $errorMsg = null;
        $this->ensureSessionStarted();
        switch ($mode) {
            default:
                // 未同意または未登録があればそのページへ移動
                if(!$_SESSION['privacyPolicy'] || !$_SESSION['termsOfService'] || !$_SESSION['completedToUserDetailRegistration']){
                    header('Location: ' .HOST_NAME .'/userDetail.php');
                    exit();
                }
                $_SESSION['name'] = 'test';
                $templateDir .= 'main.tpl';
                break;
            }
        $this->assign([
            'errorMsg' => $errorMsg,
        ]);
        $this->display($templateDir);
    }

    private function ensureSessionStarted() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}
