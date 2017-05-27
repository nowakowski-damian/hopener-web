<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/hopener/';
require_once($path.'utils/Config.php');
session_start();
session_unset();
header('Location: ../index.php');
@unlink($_SERVER['DOCUMENT_ROOT'].'/hopener/'.Config::WRITABLE_DIR.'temp'.md5(session_id()).'.png');