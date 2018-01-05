<?php
require_once("../inc/config.php");
if(!isset($_SESSION["rights"]))
{
    header("Location: ../inc/login.php");
    exit;
}

$rights = $_SESSION["rights"];
if ($rights != 4)
{
    echo "Недостаточно прав";
    exit;
}

$users = get_table_from_db("users");
if (!$users)
{
    echo "Ошибка при получении данных по таблице users";
    exit;
}
include("userstable.php");
?>