<?php
require_once("config.php");
//fo_error_msg("logout started");
flushMemberSession();
//fo_error_msg("Session Flushed");
require_once("login.php");
?>