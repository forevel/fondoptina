<?php
/* Редактирование проектов */

require_once("../inc/config.php");

$title="Редактор проектов";
$action = $_GET['action'];
$id = $_GET['id'];

// считать права доступа к сайту через SESSION
if(isset($_SESSION["rights"]))
{
    if(isset($_POST["submit"]))
    {
        $keysvalues = array(
            "name" => $_POST["name"],
            "pic" => $_POST["image"],
            "descr" => $_POST["descr"],
            "lat" => $_POST["lat"],
            "log" => $_POST["log"],
        );

        if ($action == "new")
        {
            $row = get_table_from_db_with_conditions("projects", array('name'), array('name' => $_POST['name']));

/*            $query="SELECT `name` FROM `projects` WHERE `name`='".$_POST["name"]."'";

            $result=mysqli_query($link,$query);
            if (!$result)
            {
                printf();
                return false;
            }

            if( ($row=mysqli_fetch_assoc($result)) )
            {
                $messages[]="Проект \"".$_POST["name"]."\" уже имеется, попробуйте другой";
            } */
            
            if ($row == RESULT_ERROR)
            {
                error_msg("Selecting info failed. Error: ".mysqli_error($link));
                return RESULT_ERROR;
            }
            if ($row != RESULT_EMPTY) // there's already this name in db
            {
                error_msg("Проект \"".$_POST["name"]."\" уже имеется, попробуйте другой");
            }
            else
            {
                // создаём массив
                $result = newRecord("projects", $keysvalues);
                if ($result) // всё прошло хорошо
                {
                    header("Location: projectstable.php");
                    exit;
                }
            }
        }
        else if (($action == "edit") && isset($id))
        {
            update_table_with_values("projects", $keysvalues, $id);
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
                delete_from_db("projects", $id);
            }
            // action = edit
            else if ($action == "edit")
            {
                $fields = array(); // empty array
                $keysvalues = array(
                    "id" => $id,
                );
                $result = get_table_from_db_with_conditions("projects", $fields, $keysvalues);
                if (!$result)
                    header("Location: projectstable.php");
                $row = $result[0];
                $name = $row['name'];
                $image = $row['pic'];
                $descr = $row['descr'];
                $lat = $row['lat'];
                $log = $row['log'];
            }
        }
    }
}
?>
<html>
<head>
    <title><?php print $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="../js/map_event.js" type="text/javascript"></script>
    <style>
        #map
        {
            width: 50%; height: 50%; padding: 0; margin: 0;
        }
    </style>
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
        <td><input type="number" id="lat" name="lat" value="<?php print isset($lat) ? $lat : ""; ?>"></td>
        <td> Долгота:</td>
        <td><input type="number" id="log" name="log" value="<?php print isset($log) ? $log : ""; ?>"></td>
    </tr>
    <tr>
        <td>Фотография проекта:</td>
        <td><select name="image">
            <option value="heartg" selected>Дети</option>
            <option value="heartp">Семьи</option>
            <option value="christ">Церкви</option>
            <option value="building">Здания</option>
        </select></td>
            
<!--        <input type="file" name="image" value="<?php print isset($image) ? $image : "" ; ?>"></td> -->
    </tr>
    <tr>
        <td>Описание проекта</td>
    </tr>
    <tr>
        <td><textarea name="description" value="<?php print isset($descr) ? $descr : ""; ?>"></textarea></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input name="submit" type="submit" value="Submit"></td>
    </tr>
</table>
</form>
</body>
</html>