<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/hopener/';
require_once($path.'utils/Session.php');
require_once($path.'utils/Strings.php');
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
    <title>Add device</title>
    <link rel="stylesheet" href="libs/Font-Awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
</head>

<body>

<div id="top-nav">
    <a href="device_list.php"> <i class="fa fa-list-alt" aria-hidden="true"></i> Devices list</a>
    <a href="add_device.php"> <i class="fa fa-plus-square-o" aria-hidden="true"></i> Add device</a>
    <a id="nav-logout" href="action/logout.php">  <i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
</div>

<div class="container" id="add-device-container">

    <span id="above-input-text">1) Scan this qr code on your device:</span> <br>

    <div id="qrcode-image">
        <?php
        require_once ($path."libs/phpqrcode/qrlib.php");
        require_once ($path."utils/Config.php");

        $bytes = random_bytes(127);
        $uuid = uniqid(bin2hex($bytes),true);
        $filename = $_SERVER['DOCUMENT_ROOT'].'/hopener/'.Config::WRITABLE_DIR.'temp'.md5(session_id()).'.png';
        QRcode::png($uuid, $filename, Config::CORRECTION_LEVEL, Config::QR_SIZE, 2);
        echo '<img src="'.Config::WRITABLE_DIR.basename($filename).'" /><hr/>';
        ?>
    </div>

    <div id="add-user-form">
        <form method="post" action="action/add_device.php">
            <input class="hidden" name="filename" value="<?php echo $filename; ?>">
            <input class="hidden" name="uuid" value="<?php echo $uuid; ?>">
            <span id="above-input-text">2) Type name for new device:</span> <br>
            <input class="input-form" placeholder="name" name="device_alias" required >
            <span id="above-input-text">3) Choose device access type:</span> <br>
            <label id="checkbox-text"> <input type="checkbox" name="garage_checkbox"> Garage </label> <br>
            <label id="checkbox-text"> <input type="checkbox" name="fence_checkbox""> Fence </label> <br> <br>
            <input class="button" type="submit" name="add_device" value="Add device">
        </form>

    </div>


</div>


</body>
</html>