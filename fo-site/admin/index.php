<?php
require_once(__DIR__ . "/../inc/config.php");
/*fo_error_msg("admin");
        fo_error_msg($_SESSION['rights']);
        fo_error_msg($_SESSION['loggedIn']); */

// считать права доступа к сайту через SESSION
if(!isset($_SESSION["rights"]))
{
    fo_error_msg("Не установлены права доступа для данного пользователя");
    require_once(__DIR__ . "/../inc/logout.php");
    exit;
}
// если администратор (права 4), дать ссылку редактирования пользователей
$rights = $_SESSION["rights"];
if ($rights >= 2)
{
    echo "<table align=\"center\"><tr>";
}
if ($rights >= 4)
{
//    echo "<a href=\"editusers.php\">Редактор пользователей</a><br>";
    echo "<td><a href=\"editusers.php\"><img src=\"/img/useredit.png\"></a></td>";
}
// раздел "Проекты"
// перед таблицей дать ссылку "Создать новый проект"
// дать таблицу всех проектов из БД со ссылками "Редактировать" (права 2,3) и "Удалить" (права 3)
if ($rights >= 2)
{
    echo "<td><a href=\"projectstable.php\"><img src=\"/img/projectedit.png\"></a></td>";
    echo "<td><a href=\"newstable.php\"><img src=\"/img/newsedit.png\"></a></td>";
    echo "</tr></table>";
}
// include(__DIR__ . "/editmenu.php");
?>