<?php
include_once("config.php");
checkLoggedIn("yes");
flushMemberSession();
fo_redirect("login.php");
?>