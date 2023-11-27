<?php

require_once './envPbulic.php';
require_once CLASS_PATH.'/userControl.php';

# Getメソッドの場合
$mode = 'index';
# Postメソッドの場合
if (isset($_POST['mode'])){
    $mode = $_POST['mode'];
}
$userObuject = new userControl();
$userObuject->execute($mode);
