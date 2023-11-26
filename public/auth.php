<?php

require_once './envPbulic.php';
require_once CLASS_PATH.'/authControl.php';

# Getメソッドの場合
$mode = null;
# Postメソッドの場合
if (isset($_POST['mode'])){
    $mode = $_POST['mode'];
}
$authObuject = new authControl();
$authObuject->execute($mode);