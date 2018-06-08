<?php
require_once(__DIR__ . "/../inc/f_main.php");
//fo_error_msg("members started");
$check = checkLoggedIn();
if ($check)
{
//    fo_error_msg("LoggedIn");
    require_once(__DIR__ . "/index.php");
    exit;
}
else
{
//    fo_error_msg("NotLoggedIn");
    require_once(__DIR__ . "/login.php");
    exit;
}
?>