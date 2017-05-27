<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/hopener/';
require_once($path.'utils/Session.php');
session_start();
if( isset($_SESSION[Session::LOGGED_IN]) ) {
    header('Location: device_list.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
</head>

<body>

<div class="container" id="login-container">
    <?php
    if( isset($_SESSION[Session::ERROR_MESSAGE]) ) {
        echo '<div class="error">'.$_SESSION[Session::ERROR_MESSAGE].'</div>';
        unset($_SESSION[Session::ERROR_MESSAGE]);
    }
    ?>
    <form action="action/login.php" method="post">
        <input class="input-form" type="text" name="username" placeholder="login" required="required"/>
        <input class="input-form" type="password" name="password" placeholder="password" required="required"/>
        <input class="button" type="submit" value="Login"/>
    </form>
</div>

</body>
</html>

