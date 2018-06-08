<?php
require_once(__DIR__ . "/../inc/f_main.php");
// считать права доступа к сайту через SESSION
if(isset($_SESSION["rights"]))
{
    $newsr = getFullTable("news");
    if ($newsr == RESULT_EMPTY)
        $newsr = array();
    if ($newsr == RESULT_ERROR)
    {
        fo_error_msg("Selecting info failed. Error: ".mysqli_error($link));
        exit;
    }
}
else
{
//    fo_error_msg("Не заданы права пользователя");
    require_once(__DIR__ . "/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Редактор новостей</title>
    <meta charset="UTF-8">
</head>

<body>
<div>
    <h1>Проекты</h1>
    <a href="editnews.php?action=new">Добавить новость</a><br>
    <table border="1">
        <tr>
            <th>ИД</th>
            <th>Дата</th>
            <th>Заголовок</th>
            <th>Содержание</th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach($newsr as $p): ?>
        <tr>
            <td><?=$p['id']?></td>
            <td><?=$p['date']?></td>
            <td><?=$p['caption']?></td>
            <td><?=$p['contents']?></td>
            <td><a href="editnews.php?action=edit&id=<?=$p['id']?>">Редактировать</a></td>
            <td><a href="editnews.php?action=delete&id=<?=$p['id']?>">Удалить</a></td>
        </tr>
        <?php endforeach ?>
    </table>
</div>
<a href="admin.php">Назад</a>
</body>
</html>