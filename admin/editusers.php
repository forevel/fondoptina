<?php
require_once("../inc/config.php");
if(!isset($_SESSION["rights"]))
{
    fo_error_msg("Не установлены права доступа для данного пользователя");
    fo_redirect("../inc/logout.php");
    exit;
}

$rights = $_SESSION["rights"];
if ($rights != 4)
{
    fo_error_msg("Недостаточно прав");
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