<?php
require_once(__DIR__ . "/../inc/config.php");
if(!isset($_SESSION["rights"]))
{
    fo_error_msg("Не установлены права доступа для данного пользователя");
    require_once(__DIR__ . "/../inc/logout.php");
    exit;
}

$rights = $_SESSION["rights"];
if ($rights != 4)
{
    fo_error_msg("Недостаточно прав");
    exit;
}

$users = getFullTable("users");
if (!$users)
{
    echo "Ошибка при получении данных по таблице users";
    exit;
}
include(__DIR__ . "/userstable.php");
?>