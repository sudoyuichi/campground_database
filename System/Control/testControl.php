<?php

$rootPath = __DIR__ . '/..';

require_once $rootPath . '/define.php';
require_once $rootPath . CONTROL_PATH . '/CommonClass.php';  // CommonClass.phpをインクルード
$models = [
    'testModel.php',
    'userModel.php',
];
foreach ($models as $model) {
    require_once $rootPath . MODEL_PATH . '/' . $model;
}
require_once $rootPath . VIEW_PATH . '/vendor/smarty/smarty/libs/Smarty.class.php';

class testControl extends Smarty {
    
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

    public function execute($mode) {
        
        $temprateDir = 'test/';
        switch ($mode) {
            case 'index':
                $this->assign('test', 'xxxxx');
                $temprateDir .= 'index.tpl';
                break;
            case 'moveRegister':
                $temprateDir .= './../user/register.tpl';
                break;
            case 'register':
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $userModel = new userModel();
                $userModel->createUser($name,$email,$password);
                $temprateDir .= './../user/register.tpl';
                break;
            case 'dbtest':
                $testModel = new testModel();
                $status = $testModel->getTest();
                $this->assign('db_status', $status);
                $temprateDir .= 'dbtest.tpl';  // dbtestのテンプレートを用意する必要があります。
                break;
            default :
                break;
        }

        $this->display($temprateDir);
    }

}
