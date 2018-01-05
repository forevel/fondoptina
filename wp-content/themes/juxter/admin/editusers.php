<?php
echo "123";
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
foreach($users as $u)
{
    echo "<tr>\n<td><?=$['user']?></td>\n<td><?=$['rights']?></td>\n<td><a href=\"users.php?action=edit&id=<?=$['idusers']?>\">Редактировать</a></td>\n<td><a href=\"users.php?action=delete&id=<?=$['idusers']?>\">Удалить</a></td>\n</tr>";
}
?>