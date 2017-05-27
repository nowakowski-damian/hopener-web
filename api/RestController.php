<?php

require_once("RestHelper.php");
require_once("Request.php");
require_once("../db/DeviceModel.php");
require_once("../db/DatabaseManager.php");
require_once("../utils/GpioController.php");

$contentType = $_SERVER['CONTENT_TYPE'];
$restHelper = new RestHelper();

// check method
if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
    $restHelper->setHttpCode(405);
    $restHelper->echoJson("Only POST method allowed.");
    exit();
}
// check content type
if( $contentType!=='application/json' ) {
    $restHelper->setHttpCode(415);
    $restHelper->echoJson("Only application/json content type supported.");
    exit();
}
// check if content match request model
$request = new Request( file_get_contents('php://input') );
if( $request==null || !$request->isDataCorrect() ) {
    $restHelper->setHttpCode(400);
    $restHelper->echoJson("Content doesn't match request json model.");
    exit();
}
// authenticate
$db = new DatabaseManager();
$device = $db->getDevice( $request->getUuid() );
if( $device==null ) {
    $restHelper->setHttpCode(401);
    $restHelper->echoJson("Your device is not authorized.");
    exit();
}
// check permissions
$gpioController = new GpioController();
if( $request->getDevice()==="garage" ) {
    if( $device->hasGarageAccess() ) {
        $db->incrementRequestCounter($device);
        switch ( $request->getActivity() ) {
            case "open":
                $gpioController->openGarage();
                $restHelper->echoJson("Opening");
                break;
            case "close":
                $gpioController->closeGarage();
                $restHelper->echoJson("Closing");
                break;
            case "pause":
                $gpioController->pauseGarage();
                $restHelper->echoJson("Pausing");
                break;
            default:
                $restHelper->setHttpCode(400);
                $restHelper->echoJson("'".$request->getActivity()."' doesn't match 'activity' request model.");
                exit();
        }
    }
    else {
        $restHelper->setHttpCode(403);
        $restHelper->echoJson("Garage permission is not granted.");
        exit();
    }
}
else if( $request->getDevice()==="fence" ) {
    if( $device->hasFenceAccess() ) {
        $db->incrementRequestCounter($device);
        switch ( $request->getActivity() ) {
            case "open":
                $gpioController->openFence();
                $restHelper->echoJson("Opening");
                break;
            case "close":
                $gpioController->closeFence();
                $restHelper->echoJson("Closing");
                break;
            case "pause":
                $gpioController->pauseFence();
                $restHelper->echoJson("Pausing");
                break;
            default:
                $restHelper->setHttpCode(400);
                $restHelper->echoJson("'".$request->getActivity()."' doesn't match 'activity' request model.");
                exit();
        }
    }
    else {
        $restHelper->setHttpCode(403);
        $restHelper->echoJson("Fence permission is not granted.");
        exit();
    }
}
else {
    $restHelper->setHttpCode(400);
    $restHelper->echoJson("'".$request->getDevice()."' doesn't match 'device' request model.");
    exit();
}



