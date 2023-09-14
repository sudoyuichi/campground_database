<?php

require_once './envPbulic.php';
require_once CLASS_PATH.'/TestClass.php';

if(!isset($_POST['mode'])){
    $mode = 'index';
}else{
    $mode = $_POST['mode'];
}
$mode = 'dbtest';
$testObuject = new TestControlClass();
$testObuject->execute($mode);



