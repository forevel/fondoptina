<?php
require_once("config.php");
//fo_error_msg("members started");
$check = checkLoggedIn();
if ($check)
{
//    fo_error_msg("LoggedIn");
    require_once("../admin/index.php");
    exit;
}
else
{
//    fo_error_msg("NotLoggedIn");
    require_once("login.php");
    exit;
}
?>