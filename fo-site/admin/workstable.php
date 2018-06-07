<?php

require_once(__DIR__ . "/../inc/config.php");
// считать права доступа к сайту через SESSION
$projid = $id;
$_SESSION['projid'] = $projid;
if ((isset($_SESSION["rights"])) && (isset($projid)))
{
//    var_dump($projid);
    $works = getValuesByFieldsOrdered("works", array('name', 'id'), array('idprojects' => $projid));
    if ($works == RESULT_ERROR)
    {
        fo_error_msg("Ошибка получения данных по таблице works");
        require_once("projectstable.php");
        exit;
    }
    $projects = getValuesByFieldsOrdered("projects", array('name'), array('id' => $projid));
    if ($projects == RESULT_ERROR)
    {
        fo_error_msg("Ошибка получения данных по таблице projects");
        require_once("projectstable.php");
        exit;   
    }
    $project = $projects[0]['name'];
}
else
{
    fo_error_msg("Не заданы права пользователя");
    require_once(__DIR__ . "/../inc/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Редактирование работ</title>
    <meta charset="UTF-8">
</head>

<body>
<div>
    <h1>Проект: <?php print (isset($project) ? $project : ""); ?></h1>
    <a href="work.php?action=new">Новая работа</a><br>
    <table border="1">
        <tr>
            <th>ИД</th>
            <th>Наименование</th>
            <th>Редактор</th>
            <th>Удаление</th>
        </tr>
        <?php foreach($works as $w): ?>
        <tr>
            <td><?=$w['id']?></td>
            <td><?=$w['name']?></td>
            <td><a href="editwork.php?action=edit&id=<?=$w['id']?>">Редактировать</a></td>
            <td><a href="editwork.php?action=delete&id=<?=$w['id']?>">Удалить</a></td>
        </tr>
        <?php endforeach ?>
    </table>
</div>
<a href="projectstable.php">Назад</a>
</body>
</html>