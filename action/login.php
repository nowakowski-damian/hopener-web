<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/hopener/';
require_once($path.'utils/Session.php');
require_once($path.'utils/Strings.php');
session_start();

// check if already logged in
if( isset($_SESSION[Session::LOGGED_IN]) ) {
    header('Location: ../device_list.php');
    exit();
}

// check if credentials are set
if( !isset($_POST["username"],$_POST["password"]) ) {
    goBackWithError( Strings::SESSION_TIME_OUT );
}

// check if credentials are correct

require_once($path.'db/DatabaseManager.php');
$db = new DatabaseManager();

if( !$db->isUserCorrect($_POST["username"]) ) {
    $db->closeConnetion();
    goBackWithError( Strings::INVALID_LOGIN );
}

if( !$db->isPasswordCorrect($_POST["username"],$_POST["password"]) ) {
    $db->closeConnetion();
    goBackWithError( Strings::INVALID_PASSWORD );
}

// log in
$db->closeConnetion();
$_SESSION[Session::LOGGED_IN] = true;
header('Location: ../device_list.php');

function goBackWithError($message) {
    $_SESSION[Session::ERROR_MESSAGE] = $message;
    header('Location: ../index.php');
    exit();
}