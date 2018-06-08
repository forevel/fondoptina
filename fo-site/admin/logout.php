<?php
require_once(__DIR__ . "/../inc/f_login.php");
//fo_error_msg("logout started");
flushMemberSession();
//fo_error_msg("Session Flushed");
require_once("login.php");
?>