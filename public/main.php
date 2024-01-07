<?php

require_once './envPbulic.php';
require_once CLASS_PATH . '/mainControl.php';

$mode = null;

$userObuject = new mainControl();
$userObuject->execute($mode);
