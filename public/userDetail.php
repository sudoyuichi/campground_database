<?php

require_once './envPbulic.php';
require_once CLASS_PATH.'/userDetailControl.php';

# Getメソッドの場合
$mode = null;
if (isset($_GET['mode'])){
    $mode = $_GET['mode'];
}
# Postメソッドの場合
if (isset($_POST['mode'])){
    $mode = $_POST['mode'];
}
$userDetailObuject = new userDetailControl();
$userDetailObuject->execute($mode);