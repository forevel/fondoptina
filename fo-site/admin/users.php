<?php
require_once(__DIR__ . "/../inc/f_main.php");

$database = 'users';
$title="Редактор пользователей";
if (isset($_GET['action']))
    $usersaction = $_GET['action'];
else
    $usersaction = "";

if (isset($_GET['id']))
    $userid = $_GET['id'];
else
    $userid = "";

if(isset($_SESSION["rights"]))
{
//    $action = $_SESSION['user_action'];
    if (isset($_POST["submit"]))
    {
        if (isset($_POST["user"]))
        {
            $newpsw = $_POST['newpsw'];
            $newpsw2 = $_POST['newpsw2'];
            if ($newpsw != $newpsw2)
            {
                fo_error_msg("Пароли не совпадают: $newpsw $newpsw2");
                require_once("editusers.php");
                exit;
            }
//            $userid = $_SESSION['user_id'];
            if ($usersaction == "new")
            {
                $keysvalues = array(
                    "user" => $_POST["user"],
                    "psw" => password_hash($_POST['newpsw'], PASSWORD_DEFAULT),
                    "rights" => $_POST["rights"],
                );
                $row = getValuesByFieldsOrdered($database, array('user'), array('user' => $_POST['user']));

                if ($row == RESULT_ERROR)
                {
                    fo_error_msg("Selecting info failed. Error: ".mysqli_error($link));
                    exit;
                }
                if ($row != RESULT_EMPTY) // there's already this name in db
                {
                    fo_error_msg("Пользователь \"".$_POST['user']."\" уже имеется, попробуйте другой");
                    exit;
                }
                else
                {
                    // создаём массив
                    $userid = newRecord($database, $keysvalues);
                }
            }
            else if (($usersaction == "edit") && isset($userid))
            {
                if ($newpsw == "") // пароль задавать не хотим
                {
                        $keysvalues = array(
                            "user" => $_POST["user"],
                            "rights" => $_POST["rights"],
                        );
                        if (updateTableById($database, $keysvalues, $userid) != RESULT_GOOD)
                        {
                            fo_error_msg("Ошибка при записи");
                            exit;
                        }
                }
                else
                {
                    // проверяем, совпадает ли oldpsw со старым паролем в БД
                    $row = getValuesByFieldsOrdered($database, array('psw'), array('user' => $_POST['user']));
                    if ($row != RESULT_ERROR)
                    {
                        $oldpsw = $_POST['oldpsw'];
                        field_validator("password", $oldpsw, "string", 1, 99);
                        field_validator("new password", $newpsw, "string", 8, 21);
                        if (password_verify($oldpsw, $row[0]['psw']))
                        {
                            $keysvalues = array(
                                "user" => $_POST["user"],
                                "psw" => password_hash($newpsw, PASSWORD_DEFAULT),
                                "rights" => $_POST["rights"],
                            );
                            if (updateTableById($database, $keysvalues, $userid) != RESULT_GOOD)
                            {
                                fo_error_msg("Ошибка при записи");
                                exit;
                            }
                        }
                        else
                        {
                            fo_error_msg("Старый пароль не подошёл");
                            require_once("editusers.php");
                            exit;
                        }
                    }
                    else
                    {
                        fo_error_msg("Ошибка получения данных по базе user");
                        require_once("editusers.php");
                        exit;
                    }
                }
            }
            fo_error_msg("Записано успешно!");
            require_once("editusers.php");
            exit;
        }
        else
        {
            fo_error_msg("Ошибка, не установлен user");
            require_once("index.php");
            exit;
        }
    }
    else // пока форму не отправляли
    {
        if(isset($usersaction))
        {
            if ($usersaction == "new")
            {
                fo_error_msg("0");
                // ничего не делаем, вставим потом
            }
            else if (($usersaction == 'delete') && isset($userid))
            {
                deleteFromTableById($database, $userid);
                fo_error_msg("Удалено успешно!");
                require_once("editusers.php");
                exit;
            }
            // action = edit
            else if ($usersaction == "edit")
            {
                $fields = array(); // empty array
                $keysvalues = array(
                    "id" => $userid,
                );
                $result = getValuesByFieldsOrdered($database, $fields, $keysvalues);
                if ($result == RESULT_ERROR)
                {
                    fo_error_msg("Ошибка получения данных по таблице user");
                    exit;
                }
                $row = $result[0];
                $name = $row['user'];
                $userrights = $row['rights'];
            }
        }
    }
}
else
{
    fo_error_msg("Не установлены права либо отсутствует action");
    fo_error_msg($_SESSION['rights']."__".$_GET['action']);
    require_once("index.php");
    exit;
}

?>
<html>
<head>
    <title><?php print $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="/js/users.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/css/divtable.css">
</head>
<body>
<h1><?php print $title; ?></h1>
<form action="" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Имя пользователя:</td>
            <td><input type="text" name="user" value="<?php print isset($name) ? $name : "" ; ?>"></td>
        </tr>
        <tr>
            <td>Права пользователя:</td>
            <td><select name="rights">
                <option value="0" <?php print (isset($userrights) && ($userrights == 0)) ? "selected" : "" ?>>Нет прав</option>
                <option value="1" <?php print (isset($userrights) && ($userrights == 1)) ? "selected" : "" ?>>Добавлять новости</option>
                <option value="2" <?php print (isset($userrights) && ($userrights == 2)) ? "selected" : "" ?>>Редактировать проекты</option>
                <option value="4" <?php print (isset($userrights) && ($userrights == 4)) ? "selected" : "" ?>>Все права</option>
            </select></td>
        </tr>
        <tr>
            <td>Старый пароль:</td>
            <td>
                <input name="oldpsw" type="password" class="divtablecell" />
            </td>
        </tr>
        <tr>
            <td>Новый пароль:</td>
            <td>
                <input name="newpsw" type="password" class="divtablecell" />
            </td>
        </tr>
        <tr>
            <td>Новый пароль ещё раз:</td>
            <td>
                <input name="newpsw2" type="password" class="divtablecell" />
            </td>
        </tr>
        <tr>
            <td>
                <input name="submit" type="submit" value="Отправить в базу">
            </td>
        </tr>
    </table>
    <br />
</form>
    <a href="editusers.php">Назад</a>
    <span id="tempout"></span>
    </body>
</html>