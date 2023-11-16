<?php

$rootPath = __DIR__ . '/..';

require_once $rootPath . '/define.php';
require_once $rootPath . CONTROL_PATH . '/CommonClass.php';  // CommonClass.phpをインクルード
require_once $rootPath . MODEL_PATH . '/userModel.php';
require_once $rootPath . VIEW_PATH . '/vendor/smarty/smarty/libs/Smarty.class.php';

class authControl extends Smarty {
    
    private $rootPath;
    private $common;  // CommonClassのインスタンスを保持するプロパティ

    public function __construct() {
        global $rootPath;
        $this->rootPath = $rootPath;
        // CommonClassのインスタンスを作成
        $this->common = new CommonClass();
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
        $temprateDir = 'Auth/';
        switch ($mode) {
            case 'index':
                $temprateDir .= 'index.tpl';
                break;
            case 'register':
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $userModel = new userModel();
                $userModel->createUser($name,$email,$password);
                $temprateDir .= 'index.tpl';
                break;
            default :
                break;
        }
        $this->display($temprateDir);
    }
}
