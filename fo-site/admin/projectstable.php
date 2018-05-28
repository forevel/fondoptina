<?php

require_once(__DIR__ . "/../inc/config.php");
// считать права доступа к сайту через SESSION
if(isset($_SESSION["rights"]))
{
    $projects = getFullTable("projects");
}
else
{
    fo_error_msg("Не заданы права пользователя");
    require_once(__DIR__ . "/../inc/login.php");
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
            <th>Дела по проекту</th>
        </tr>
        <?php foreach($projects as $p): ?>
        <tr>
            <td><?=$p['id']?></td>
            <td><?=$p['name']?></td>
            <td><a href="projects.php?action=edit&id=<?=$p['id']?>">Редактировать</a></td>
            <td><a href="projects.php?action=delete&id=<?=$p['id']?>">Удалить</a></td>
            <td><a href="workstable.php?id=<?=$p['id']?>">Изменить</a></td>
        </tr>
        <?php endforeach ?>
    </table>
</div>
<a href="admin.php">Назад</a>
</body>
</html>