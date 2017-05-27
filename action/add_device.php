<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/hopener/';
require_once($path.'utils/Session.php');
require_once($path.'utils/Strings.php');
require_once($path.'db/DatabaseManager.php');
require_once($path.'db/DeviceModel.php');
session_start();

if( !isset($_SESSION[Session::LOGGED_IN]) ) {
    $_SESSION[Session::ERROR_MESSAGE] = Strings::SESSION_TIME_OUT;
    header('Location: ../index.php');
    exit();
}

if( !isset($_POST["filename"],$_POST["uuid"],$_POST["device_alias"]) ) {
    header('Location: ../index.php');
    exit();
}

unlink($_POST["filename"]);
$db = new DatabaseManager();
$db->addDevice(password_hash($_POST["uuid"],PASSWORD_DEFAULT),$_POST["device_alias"],isset($_POST["garage_checkbox"]),isset($_POST["fence_checkbox"]));
$db->closeConnetion();

echo isset($_POST["garage_checkbox"]).' : '.isset($_POST["fence_checkbox"]);
header('Location: ../index.php');

