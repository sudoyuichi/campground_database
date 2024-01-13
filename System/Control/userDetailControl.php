<?php

$rootPath = __DIR__ . '/..';

require_once $rootPath . '/define.php';
require_once $rootPath . CONTROL_PATH . '/commonControl.php';  // commonControl.phpをインクルード
require_once $rootPath . MODEL_PATH . '/userDetailModel.php';
require_once $rootPath . VIEW_PATH . '/vendor/smarty/smarty/libs/Smarty.class.php';

class userDetailControl extends Smarty {
    private $rootPath;
    private $common;  // commonControlのインスタンスを保持するプロパティ
    private $userDetailModel;
    public function __construct() {
        global $rootPath;
        $this->rootPath = $rootPath;
        // commonControlのインスタンスを作成
        $this->common = new commonControl();
        // ここでセッションのisLoginがTrueかチェック
        if(!$this->common->authenticateSession()){
            // ログインされてなければログイン画面へリダイレクト
            header('Location: ' .HOST_NAME .'/auth.php');
            exit();
        }
        parent::__construct();
        $this->setTemplateDir($this->rootPath . VIEW_PATH . '/templates/');
        $this->setCompileDir($this->rootPath . VIEW_PATH . '/templates_c/');
        $this->setCacheDir($this->rootPath . VIEW_PATH . '/cache/');
        $this->setConfigDir($this->rootPath . VIEW_PATH . '/configs/');
        $this->userDetailModel = new userDetailModel();
        $this->common->verifyRegistrationProgress($this->userDetailModel);
    }

    /**
     * 指定されたモードに基づいて操作を実行し、テンプレートを表示
     * @param string $mode モード
     */
    public function execute($mode) {
        $templateDir = 'UserDetail/';
        switch ($mode) {
            case 'privacy_policy_agreed':
                $_SESSION['privacyPolicy'] = $this->userDetailModel->updateAgreementTime($_SESSION['user_id'], $mode);
                header('Location: ' .HOST_NAME .'/userDetail.php');
                exit();
            case 'terms_of_service_agreed':
                $_SESSION['termsOfService'] = $this->userDetailModel->updateAgreementTime($_SESSION['user_id'], $mode);
                header('Location: ' .HOST_NAME .'/userDetail.php');
                exit();
            case 'userDetailRegister':
                $birthdate = $_POST['birthdate'];
                $residence_prefecture = $_POST['residence_prefecture'];
                $nick_name = $_POST['nick_name'];
                $twitter_url = $_POST['twitter_url'];
                $instagram_url = $_POST['instagram_url'];
                $youtube_channel_url = $_POST['youtube_channel_url'];
                $blog_url = $_POST['blog_url'];
                $icon_url = $_POST['icon_url'];
                $profile_image_url = $_POST['profile_image_url'];
                $self_introduction = $_POST['self_introduction'];
                $_SESSION['completedToUserDetailRegistration'] = $this->userDetailModel->updateUserDetail(
                    $birthdate, $residence_prefecture, $nick_name, $twitter_url, $instagram_url, $youtube_channel_url, $blog_url,
                    $icon_url, $profile_image_url, $self_introduction, $_SESSION['user_id'],);
                header('Location: ' .HOST_NAME .'/userDetail.php');
                exit();
            case 'showModifyUserDetail':
                $templateDir .= 'modifyUserDetail.tpl';
                break;
            case 'showUserDetail':
                $templateDir .= 'showUserDetail.tpl';
                break;
            default:
                if ($_SESSION['privacyPolicy'] == false) {
                    $templateDir .= 'privacyPolicy.tpl';
                    break;
                } elseif ($_SESSION['termsOfService'] == false) {
                    $templateDir .= 'termsOfService.tpl';
                    break;
                } elseif ($_SESSION['completedToUserDetailRegistration'] == false) {
                    $templateDir .= 'userDetailRegister.tpl';
                    break;
                } else {
                    $templateDir .= 'showUserDetail.tpl';
                    break;
                }
            }
        $this->display($templateDir);
    }

    // 以下のメソッドは使用していなが、念の為残す
    public function getPrivacyPolicyAgreementFromUserId($user_id){
        $user_data = $this->getUserDetailFromUserId($user_id);
        return $user_data['privacy_policy_agreed'];
    }

    public function getTermsOfServiceAgreedFromUserId($user_id){
        $user_data = $this->getUserDetailFromUserId($user_id);
        return $user_data['terms_of_service_agreed'];
    }

    public function getNickNameFromUserId($user_id){
        $user_data = $this->getUserDetailFromUserId($user_id);
        return $user_data['nick_name'];
    }
}
