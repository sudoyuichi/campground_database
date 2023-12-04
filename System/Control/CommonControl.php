<?php

class CommonControl {

    public function __construct() {
        // 日本のタイムゾーンを設定
        date_default_timezone_set('Asia/Tokyo');
    }
    
    // 他の共通機能やメソッドもこちらに追加することができます。
    // ログイン認証メソッドを追加
}
