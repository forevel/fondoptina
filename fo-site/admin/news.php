<?php
/* Редактирование новостей */
require_once(__DIR__ . "/../inc/config.php");

$title="Редактор новостей";
$isnew=true;

if (isset($_GET['action']))
{
    $_SESSION['news_action'] = $_GET['action'];
    $action = $_SESSION['news_action'];
    if ((($action == "edit") || ($action == "delete")) && (isset($_GET['id'])))
        $_SESSION["news_id"] = $_GET['id'];
    // считать права доступа к сайту через SESSION
    if((isset($_SESSION["rights"])) && (isset($_SESSION['news_action'])))
    {
        if (isset($_POST["submit"]))
        {
            $isnew=false;
            if (isset($_POST["caption"]))
            {
                $keysvalues = array(
                    "date" => date('Y-m-d'),
                    "caption" => $_POST["caption"],
                    "contents" => $_POST["contents"],
                    "user" => $_SESSION["login"],
                );
                
                if ($action == "new")
                {
                    $row = getValuesByFieldsOrdered("news", array('caption'),   array('caption' => $_POST["caption"]));

                    if ($row == RESULT_ERROR)
                    {
                        fo_error_msg("Selecting info failed. Error:     ".mysqli_error($link));
                        $isnew=true;
                    }
                    if ($row != RESULT_EMPTY) // there's already this name in db
                    {
                        $errormsg = "Новость \"".$_POST["caption"]."\" уже имеется,     попробуйте другую";
                        fo_error_msg($errormsg);
//                        fo_error_msg("Новость с таким названием уже существует");
                        $isnew=true;
                    }
                    else
                    {
                        // создаём массив
                        $id = newRecord("news", $keysvalues);
                        if ($id != RESULT_ERROR) // всё прошло хорошо
                        {
                            fo_error_msg("Записано успешно!");
                            require_once("newstable.php");
                            exit;
                        }
                    }
                }
                else if (($action == "edit") && isset($_SESSION['news_id']))
                {
                    if (updateTableById("news", $keysvalues, $_SESSION['news_id']) !=   RESULT_GOOD)
                    {
                        fo_error_msg("Ошибка при записи");
                        $isnew=true;
                    }
                    fo_error_msg("Записано успешно!");
                    require_once("newstable.php");
                    exit;
                }
            }
            else
            {
                require_once("newstable.php");
                exit;
            }
        }
        if ($isnew) // пока форму не отправляли
        {
            if(isset($action))
            {
                if ($action == "new")
                {   
                    // ничего не делаем, вставим потом
                    $date = date('Y-m-d');
                    $user = $_SESSION["login"];
                }
                else if ($action == 'delete')
                {
                    deleteFromTableById("news", $_SESSION["news_id"]);
                    require_once("newstable.php");
                    exit;
                }
                // action = edit
                else if ($action == "edit")
                {
                    $fields = array(); // empty array
                    $keysvalues = array(
                        "id" => $_SESSION['news_id'],
                    );
                    $result = getValuesByFieldsOrdered("news", $fields, $keysvalues);
                    if (!$result)
                        exit;
                    $row = $result[0];
                    $date = $row['date'];
				    $caption = $row['caption'];
                    $contents = $row['contents'];
                    $user = $row['user'];
                }
            }
        }
    }
    else
    {
        fo_error_msg("Не установлены права либо отсутствует action");
        require_once("index.php");
        exit;
    }
}
?>
<html>
<head>
    <title><?php print $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="/css/divtable.css">
</head>
<body>
<h1><?php print $title; ?></h1>
<form action="" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Заголовок новости:</td>
            <td><input type="text" name="caption" size="78" value="<?php print isset($caption) ? $caption : "" ; ?>"></td>
        </tr>
        <tr>
            <td>Содержание новости</td>
            <td colspan="3"><textarea name="contents" cols="80" rows="5"><?php print isset($contents) ? $contents : ""; ?></textarea></td>
        </tr>
        <tr>
            <td>Исполнитель:<?php print $user ?></td>
        </tr>
        <tr>
            <td>Дата новости:<?php print $date ?></td>
        </tr>
    </table>
    <input name="submit" type="submit" value="Submit"><br />
</form>
    <a href="newstable.php">Назад</a>
    <span id="tempout"></span>
    </body>
</html>