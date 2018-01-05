<?php
require_once("../inc/config.php");
// считать права доступа к сайту через SESSION
if(!isset($_SESSION["rights"]))
{
    header("Location: ../inc/login.php");
    exit;
}
// если администратор (права 4), дать ссылку редактирования пользователей
$rights = $_SESSION["rights"];
if ($rights == 4)
{
    echo "<a href=\"editusers.php\">Редактор пользователей</a><br>";
}
// раздел "Проекты"
// перед таблицей дать ссылку "Создать новый проект"
// дать таблицу всех проектов из БД со ссылками "Редактировать" (права 2,3) и "Удалить" (права 3)
include("projectstable.php");
?>