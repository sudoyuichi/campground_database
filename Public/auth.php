<?php

require_once './envPbulic.php';
require_once CLASS_PATH.'/authControl.php';

# Getメソッドの場合
$mode = 'index';

$authObuject = new authControl();
$authObuject->execute($mode);