<?php

require_once './envPbulic.php';
require_once CLASS_PATH.'/testControl.php';

$mode = 'index';
if(isset($_GET['mode'])){
    if($_GET['mode'] === 'moveRegister'){
        $mode = 'moveRegister';
    }
}

if (isset($_POST['mode'])){
    $mode = $_POST['mode'];
}

$testObuject = new testControl();
$testObuject->execute($mode);
