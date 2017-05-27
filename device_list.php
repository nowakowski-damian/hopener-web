<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/hopener/';
require_once('utils/Session.php');
require_once('utils/Strings.php');
session_start();
if( !isset($_SESSION[Session::LOGGED_IN]) ) {
    $_SESSION[Session::ERROR_MESSAGE] = Strings::SESSION_TIME_OUT;
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Device list</title>
    <link rel="stylesheet" href="libs/Font-Awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
</head>

<body>

<div id="top-nav">
    <a href="device_list.php"> <i class="fa fa-list-alt" aria-hidden="true"></i> Devices list</a>
    <a href="add_device.php"> <i class="fa fa-plus-square-o" aria-hidden="true"></i> Add device</a>
    <a id="nav-logout" href="action/logout.php">  <i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
</div>

<div id="device-list-container" class="container" >

    <table class="device_table">
        <tr>
            <th>Name</th>
            <th>Fence</th>
            <th>Garage</th>
            <th>Successful request count</th>
            <th>Last access [UTC]</th>
            <th></th>
        </tr>

        <?php
        require_once($path.'db/DeviceModel.php');
        require_once($path.'db/DatabaseManager.php');
        $db = new DatabaseManager();
        $devices = $db->getDevices();
        if( count($devices) ) {
            foreach ($devices as $device) {
                echo "<tr>".
                    "<td>".$device->getName()."</td>".
                    "<td>". ($device->hasFenceAccess() ? "<i id='image-green' class='fa fa-check-circle-o fa-lg' aria-hidden='true'/>":"<i id='image-red' class='fa fa-times-circle-o fa-lg' aria-hidden='true'/>")."</td>".
                    "<td>". ($device->hasGarageAccess() ? "<i id='image-green' class='fa fa-check-circle-o fa-lg' aria-hidden='true'/>":"<i id='image-red' class='fa fa-times-circle-o fa-lg' aria-hidden='true'/>")."</td>".
                    "<td>".$device->getRequestNum()."</td>".
                    "<td>".$device->getTimestamp()."</td>".
                    "<td>".
                        "<form action='action/forget.php' method='post'>".
                            "<input class='hidden' name='deviceId' value='".$device->getId()."'>".
                            "<input id='delete-button' type='submit' name='forget' value='forget'>".
                        "</form>".
                    "</td>".
                    "</tr>";
            }
        }
        else {
            echo "<tr><td colspan='6'>There is no device added.</td></tr>";
        }
        $db->closeConnetion();
        ?>
    </table>

</div>

</body>
</html>