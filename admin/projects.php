<?php
/* Редактирование проектов */

require_once("../inc/config.php");

$title="Редактор проектов";

if (isset($_GET['action']))
{
    $_SESSION['proj_action'] = $_GET['action'];
    if (($_GET['action'] == "edit") && (isset($_GET['id'])))
        $_SESSION['proj_id'] = $_GET['id'];
}
// считать права доступа к сайту через SESSION
if((isset($_SESSION["rights"])) && (isset($_SESSION['proj_action'])))
{
    $action = $_SESSION['proj_action'];
    if(isset($_POST["submit"]))
    {
        $keysvalues = array(
            "name" => $_POST["name"],
            "pic" => $_POST["image"],
			"cat" => $_POST["cat"],
            "descr" => $_POST["descr"],
            "lat" => $_POST["lat"],
            "log" => $_POST["log"],
            "pic2" => $_POST["image2"],
            "pic3" => $_POST["image3"],
            "url" => $_POST["url"],
        );

        if ($action == "new")
        {
            $row = get_table_from_db_with_conditions("projects", array('name'), array('name' => $_POST['name']));

            if ($row == RESULT_ERROR)
            {
                fo_error_msg("Selecting info failed. Error: ".mysqli_error($link));
                return RESULT_ERROR;
            }
            if ($row != RESULT_EMPTY) // there's already this name in db
            {
                fo_error_msg("Проект \"".$_POST["name"]."\" уже имеется, попробуйте другой");
            }
            else
            {
                // создаём массив
                $result = newRecord("projects", $keysvalues);
                if ($result == RESULT_GOOD) // всё прошло хорошо
                {
                    fo_redirect("projectstable.php");
                    exit;
                }
            }
        }
        else if (($action == "edit") && isset($_SESSION['proj_id']))
        {
            if (update_table_with_values("projects", $keysvalues, $_SESSION['proj_id']) == RESULT_GOOD)
            {
                fo_error_msg("Записано успешно!");
                fo_redirect("projectstable.php");
            }
        }

    }
    else // пока форму не отправляли
    {
        if(isset($action))
        {
            if ($action == "new")
            {
                // ничего не делаем, вставим потом
            }
            else if ($action == 'delete')
            {
                delete_from_db("projects", $_SESSION['proj_id']);
            }
            // action = edit
            else if ($action == "edit")
            {
                $fields = array(); // empty array
                $keysvalues = array(
                    "id" => $_SESSION['proj_id'],
                );
                $result = get_table_from_db_with_conditions("projects", $fields, $keysvalues);
                if (!$result)
                    header("Location: projectstable.php");
                $row = $result[0];
                $name = $row['name'];
                $image = $row['pic'];
                $image2 = $row['pic2'];
                $image3 = $row['pic3'];
				$cat = $row['cat'];
                $descr = $row['descr'];
                $lat = $row['lat'];
                $log = $row['log'];
                $url = $row['url'];
            }
        }
    }
}
else
{
    fo_error_msg("Не установлены права либо отсутствует action");
    exit;
}
?>
<html>
<head>
    <title><?php print $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="../js/map_event.js" type="text/javascript"></script>
<!--	<script src="../js/jquery-3.2.1.min.js" type="text/javascript"></script> -->
    <script src="../js/img_preview.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../css/imgpreview.css">
    <style>
        #map
        {
            width: 50%; height: 50%; padding: 0; margin: 0;
        }
    </style>
	<script type="text/javascript">
	</script>
</head>
<body>
<h1><?php print $title; ?></h1>
<?php
if(!empty($messages)){
  displayErrors($messages);
}
?>
<div id="map"></div>
<form action="<?php print $_SERVER['PHP_SELF']; ?>" method="POST">
<table>
    <tr>
        <td>Наименование проекта:</td>
        <td><input type="text" name="name" value="<?php print isset($name) ? $name : "" ; ?>"></td>
    </tr>
    <tr>
        <td>Местонахождение. Широта:</td>
        <td><input id="lat" name="lat" value="<?php print isset($lat) ? $lat : ""; ?>"></td>
        <td> Долгота:</td>
        <td><input id="log" name="log" value="<?php print isset($log) ? $log : ""; ?>"></td>
    </tr>
    <tr>
        <td>Тип проекта:</td>
        <td><select name="cat">
            <option value="0" <?php print (isset($cat) && ($cat == 0)) ? "selected" : "" ?>>Дети</option>
            <option value="1" <?php print (isset($cat) && ($cat == 1)) ? "selected" : "" ?>>Семьи</option>
            <option value="2" <?php print (isset($cat) && ($cat == 2)) ? "selected" : "" ?>>Церкви</option>
            <option value="3" <?php print (isset($cat) && ($cat == 3)) ? "selected" : "" ?>>Здания</option>
        </select></td>
    </tr>
    <tr>
        <td>Описание проекта</td>
        <td colspan="3"><textarea name="descr"><?php print isset($descr) ? $descr : ""; ?></textarea></td>
    </tr>
    <tr>
        <td>Страница проекта:</td>
        <td colspan="3"><input type="text" name="url" value="<?php print isset($url) ? $url : "" ; ?>"></td>
    </tr>
    <tr>
        <td>Фотографии проекта</td>
        <td><input type="file" name="image" class="imgInp" value="<?php print isset($image) ? $image : "" ; ?>" onchange="previewImage("imgP1", this.files[0])"></td>
        <td><img id="imgP1" src="#"></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="file" name="image2" class="imgInp" value="<?php print isset($image2) ? $image2 : "" ; ?>" onchange="previewImage("imgP2", this.files[0])"></td>
        <td><img id="imgP2" src="#"></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="file" name="image3" class="imgInp" value="<?php print isset($image3) ? $image3 : "" ; ?>" onchange="previewImage("imgP3", this.files[0])"></td>
        <td><img id="imgP3" src="#"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input name="submit" type="submit" value="Submit"></td>
    </tr>
</table>
</form>
<form>
</form>
</body>
</html>