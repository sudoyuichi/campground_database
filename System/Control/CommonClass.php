<?php

class CommonClass {

    public function __construct() {
        // 日本のタイムゾーンを設定
        date_default_timezone_set('Asia/Tokyo');
    }
    

    public function generateUUID() {
        // Generate 16 bytes (128 bits) of random data
        $data = random_bytes(16);
        
        // Set the version to 4 (random) and the variant to 1
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Convert the binary data to a hexadecimal string and remove the hyphens
        return str_replace('-', '', vsprintf('%s%s%s%s%s', str_split(bin2hex($data), 4)));
    }
}
