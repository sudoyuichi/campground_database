<?php
require_once 'dbCommonModel.php';

class userDetailModel {

    private $db;
    private $connection;
    const TABLE_NAME = 'user_details'; 

    public function __construct() {
        $this->db = new dbCommonModel();
            $this->connection = $this->db->getConnection();
    }

    /**
     * ユーザ詳細テーブルへ新規ユーザを登録
     *
     * @param int $user_id usersテーブルのID
     * @return bool 成功した場合はtrue、失敗した場合はfalse
     */
    public function createUserDetail($user_id) {
        $returnVal = false;
        try{
            # DBへとユーザ詳細登録するクエリ
            $query = $this->connection->prepare(
                "INSERT INTO " .self::TABLE_NAME . " (user_id) VALUES (:user_id)");
            $query->bindParam(':user_id', $user_id);
            $query->execute();
            $returnVal = true;
        } catch (PDOException $e) {
            $errorMessage = 'user_detailテーブルへ登録出来ませんでした。: ' . $e->getMessage();
            error_log($errorMessage);
        }
        return $returnVal;
    }

    /**
     * プライバシーポリシー、利用規約への同意時間を更新
     *
     * @param int $userId usersテーブルのID
     * @param string $mode 同意した規約から更新する列名を設定（'privacy_policy_agreed' または 'terms_of_service_agreed'）
     * @return bool 成功した場合はtrue、失敗した場合はfalse
     */
    public function updateAgreementTime($userId, $mode) {
        $returnVal = false;
        try{
            $now = date('Y-m-d H:i:s');
            // user_detailテーブルの列名
            $columnName = $mode;
            $query = $this->connection->prepare(
                'UPDATE ' .self::TABLE_NAME . ' SET ' .$columnName .' = :now WHERE user_id = :userId');
            $query->bindParam(':now', $now);
            $query->bindParam(':userId', $userId);
            $query->execute();
            $returnVal = true;
        } catch (PDOException $e) {
            $errorMessage = '規約同意日時の更新に失敗しました。: ' . $e->getMessage();
            error_log($errorMessage);
            return $returnVal;
        }
        return $returnVal;
    }

    /**
     * ユーザ詳細情報を更新 
     *
     * @param string|null $birthdate 誕生日
     * @param string $residence_prefecture 居住地（都道府県）
     * @param string $nick_name ニックネーム　※入力必須。登録済かの判定に使用する為。
     * @param string $twitter_url TwitterのURL
     * @param string $instagram_url InstagramのURL
     * @param string $youtube_channel_url YouTubeチャンネルのURL
     * @param string $blog_url ブログのURL
     * @param string $icon_url アイコンのURL
     * @param string $profile_image_url プロフィール画像のURL
     * @param string $self_introduction 自己紹介
     * @param int $user_id ユーザID
     * @return bool 成功した場合はtrue、失敗した場合はfalse
     */
    public function updateUserDetail(
            $birthdate, $residence_prefecture, $nick_name, $twitter_url, $instagram_url, $youtube_channel_url, $blog_url,
            $icon_url, $profile_image_url, $self_introduction, $user_id){
        $returnVal = false;
        try {
            $query = $this->connection->prepare(
                'UPDATE ' .self::TABLE_NAME . ' SET 
                birthdate = COALESCE(:birthdate, birthdate),
                residence_prefecture = COALESCE(:residence_prefecture, residence_prefecture),
                nick_name = COALESCE(:nick_name, nick_name),
                twitter_url = COALESCE(:twitter_url, twitter_url),
                instagram_url = COALESCE(:instagram_url, instagram_url),
                youtube_channel_url = COALESCE(:youtube_channel_url, youtube_channel_url),
                blog_url = COALESCE(:blog_url, blog_url),
                icon_url = COALESCE(:icon_url, icon_url),
                profile_image_url = COALESCE(:profile_image_url, profile_image_url),
                self_introduction = COALESCE(:self_introduction, self_introduction)
                WHERE user_id = :user_id');
            $query->bindParam(':nick_name', $nick_name);
            $query->bindParam(':user_id', $user_id);
            $query->bindParam(':birthdate', $birthdate);
            if (empty($birthdate)){
                $query->bindParam(':birthdate', $birthdate, PDO::PARAM_NULL);
            }
            $query->bindParam(':residence_prefecture', $residence_prefecture);
            $query->bindParam(':twitter_url', $twitter_url);
            $query->bindParam(':instagram_url', $instagram_url);
            $query->bindParam(':youtube_channel_url', $youtube_channel_url);
            $query->bindParam(':blog_url', $blog_url);
            $query->bindParam(':icon_url', $icon_url);
            $query->bindParam(':profile_image_url', $profile_image_url);
            $query->bindParam(':self_introduction', $self_introduction);
            $query->execute();
            $returnVal = true;
        } catch (PDOException $e) {
            $errorMessage = 'ユーザー詳細登録の更新に失敗しました。: ' . $e->getMessage();
            error_log($errorMessage);
            return $returnVal;
        }
        return $returnVal;
    }

    /**
    * user_detailテーブルからデータ取得
    * 
    * @param int $user_id usersテーブルのID
    * @return array|null user_idに合致するデータがあれば全レコード。
    */
    public function getUserDetailFromUserId($user_id){
        $userData = null;
        try{
            $query = $this->connection->prepare(
                'SELECT * FROM ' .self::TABLE_NAME . ' WHERE user_id = :user_id and deleted_at is Null');
            $query->bindParam(':user_id', $user_id);
            $query->execute();
            $userData = $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $errorMessage = 'user_detailからのデータ取得に失敗しました。: ' . $e->getMessage();
            error_log($errorMessage);
            return $userData;
        }
        return $userData;
    }
}
