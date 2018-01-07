<?php
require_once("config.php");
checkLoggedIn("yes");
/*$login = $_SESSION['login'];
$psw = $_SESSION['password'];
print("<b>$login</b>! Добро пожаловать<br>\n");
print("Ваш пароль: <b>$psw</b><br>\n");
print("<a href=\"logout.php"."\">Выход</a>"); */
fo_redirect("../admin/index.php");
?>