<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/hopener/';
require_once($path.'utils/Session.php');
require_once($path.'utils/Strings.php');
require_once($path.'db/DatabaseManager.php');

session_start();
if( !isset($_SESSION[Session::LOGGED_IN]) ) {
    $_SESSION[Session::ERROR_MESSAGE] = Strings::SESSION_TIME_OUT;
    header('Location: ../index.php');
    exit();
}

if( !isset($_POST["deviceId"]) ) {
    header("Location: ../index.php");
    exit();
}

$db = new DatabaseManager();
$db->removeDevice( $_POST["deviceId"] );
$db->closeConnetion();
header("Location: ../index.php");

