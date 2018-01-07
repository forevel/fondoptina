<?php

require_once("../inc/config.php");
// считать права доступа к сайту через SESSION
if(isset($_SESSION["rights"]))
{
    $projects = get_table_from_db("projects");
}
else
{
    fo_error_msg("Не заданы права пользователя");
    fo_redirect("../inc/login.php");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Редактирование проектов</title>
    <meta charset="UTF-8">
</head>

<body>
<div>
    <h1>Проекты</h1>
    <a href="projects.php?action=new">Новый проект</a><br>
    <table border="1">
        <tr>
            <th>ИД</th>
            <th>Наименование</th>
            <th>Редактор</th>
            <th>Удаление</th>
        </tr>
        <?php foreach($projects as $p): ?>
        <tr>
            <td><?=$p['id']?></td>
            <td><?=$p['name']?></td>
            <td><a href="projects.php?action=edit&id=<?=$p['id']?>">Редактировать</a></td>
            <td><a href="projects.php?action=delete&id=<?=$p['id']?>">Удалить</a></td>
        </tr>
        <?php endforeach ?>
    </table>
</div>
</body>
</html>