<!DOCTYPE html>
<html lang="ru">
<head>
  <title>Редактирование пользователей</title>
  <meta charset="UTF-8">
</head>

<body>
<div>
    <h1>Пользователи</h1>
    <a href="users.php?action=new">Новый пользователь</a><br>
    <table>
        <tr>
            <th>Пользователь</th>
            <th>Права доступа</th>
            <th>Редактировать</th>
            <th>Удалить</th>
        </tr>
        <?php foreach($users as $u): ?>
        <tr>
            <td><?=$u['user']?></td>
            <td><?=$u['rights']?></td>
            <td><a href="users.php?action=edit&id=<?=$u['idusers']?>">Редактировать</a></td>
            <td><a href="users.php?action=delete&id=<?=$u['idusers']?>">Удалить</a></td>
        </tr>
        <?php endforeach ?>
    </table>
</div>
    <a href="admin.php">Назад</a>
</body>
</html>