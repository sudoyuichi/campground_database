<?php

$rootPath = __DIR__ . '/..';
global $postData;

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
        if ($_POST){
            global $postData;
            $postData = $this->common->sanitizeArray($_POST);
        }
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
            // 同じ処理をするが初期登録と更新で区別する様にあえてcase名は別で設定。
            case 'userDetailRegister': // ユーザ詳細初期登録
            case 'updateUserDetail':   // ユーザ詳細更新
                $this->updateUserDetail();    
                $templateDir .= 'showUserDetail.tpl';
                break;
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
                    $_SESSION['user_data'] = $this->userDetailModel->getUserDetailFromUserId($_SESSION['user_id']);
                    break;
                }
            }
        $this->display($templateDir);
    }

    /**
     * POSTされた画像ファイルを保存し、相対パスを返却
     * 
     * @param string $file_key POSTされたファイルのキーとなる名前
     * @param string $storage_name ファイル格納場所名
     * @return string　tplファイルから画像を呼ぶ為の相対パス
     */
    public function uploadImage($file_key, $storage_name){
        if(!empty($_FILES[$file_key])){
            // ユーザIDを画像ファイルの先頭に付ける事でファイル名の重複を防止
            $filename = $_SESSION['user_id'].$_FILES[$file_key]['name'];
            $uploaded_path = $this->rootPath.'/Uploads/'.$storage_name.$filename;
            $path_from_tpl = './../System/Uploads/'.$storage_name.$filename;
            $result = move_uploaded_file($_FILES[$file_key]['tmp_name'],$uploaded_path);
            if($result){
                return $path_from_tpl;
            }else{
                error_log('アップロードファイルの保存に失敗。');
                return null;
            }
        }else{
            error_log('アップロードファイルの取得に失敗。');
            return null;
        }
    }

    /**POSTされた情報からユーザ詳細を更新*/
    public function updateUserDetail() {
        global $postData;
        $birthdate = $postData['birthdate'];
        $residence_prefecture = $postData['residence_prefecture'];
        $nick_name = $postData['nick_name'];
        $twitter_url = $postData['twitter_url'];
        $instagram_url = $postData['instagram_url'];
        $youtube_channel_url = $postData['youtube_channel_url'];
        $blog_url = $postData['blog_url'];
        $icon_url = $this->uploadImage('icon_url', 'Icon/');
        $profile_image_url = $this->uploadImage('profile_image_url', 'Profil/');
        $self_introduction = $postData['self_introduction'];
        $_SESSION['completedToUserDetailRegistration'] = $this->userDetailModel->updateUserDetail(
            $birthdate, $residence_prefecture, $nick_name, $twitter_url, $instagram_url, $youtube_channel_url, $blog_url,
            $icon_url, $profile_image_url, $self_introduction, $_SESSION['user_id']
        );
        $_SESSION['user_data'] = $this->userDetailModel->getUserDetailFromUserId($_SESSION['user_id']);
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
