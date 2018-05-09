<?php
/* Редактирование проектов */
require_once(__DIR__ . "/../inc/config.php");

function updateFiles($id)
{
    // очищаем базу от старых записей о картинках
    deleteFromTable('projectimages', 'projid', $id);
    /* надо пройтись по всем полям с именем file-name<?=$i?> и, если они начинаются
     * с "upload/", то записать их в базу по нашему $id */
    for ($i=0; $i<10; $i++)
    {
        $filename = 'file-name' . $i;
//        echo ($filename);
        if (isset($_POST[$filename]))
        {
            $filename = $_POST[$filename];
//            echo ($filename);
            if (strpos($filename, 'upload/') === false) // нет подстроки
                continue;
//            echo ("!");
            $keysvalues = array(
                'url' => $filename,
                'projid' => $id,
            );
            newRecord('projectimages', $keysvalues);
        }
    }
    // теперь пишем картинки в базу
//    var_dump($_FILES);
    foreach($_FILES as $file) {
        if (($newfilename = uploadFile($file)) != RESULT_ERROR)
        {
            $keysvalues = array(
                'url' => $newfilename,
                'projid' => $id,
            );
            newRecord('projectimages', $keysvalues);
        }
    }
}

$title="Редактор работ";
$images = array();

if (isset($_GET['action']))
{
    $_SESSION['work_action'] = $_GET['action'];
    if (($_GET['action'] == "edit") && (isset($_GET['id'])))
        $_SESSION['work_id'] = $_GET['id'];
}
// считать права доступа к сайту через SESSION
if((isset($_SESSION["rights"])) && (isset($_SESSION['work_action'])))
{
    $action = $_SESSION['work_action'];
    if (isset($_POST["submit"]))
    {
        if (isset($_POST["name"]))
        {
            $keysvalues = array(
                "name" => $_POST["name"],
                "cat" => $_POST["cat"],
                "descr" => $_POST["descr"],
                "lat" => $_POST["lat"],
                "log" => $_POST["log"],
                "idcontent" => $_POST["idcontent"],
            );

            if ($action == "new")
            {
                $row = getValuesByFieldsOrdered("projects", array('name'), array('name' => $_POST['name']));

                if ($row == RESULT_ERROR)
                {
                    fo_error_msg("Selecting info failed. Error: ".mysqli_error($link));
                    exit;
                }
                if ($row != RESULT_EMPTY) // there's already this name in db
                {
                    fo_error_msg("Проект \"".$_POST["name"]."\" уже имеется, попробуйте другой");
                    exit;
                }
                else
                {
                    // создаём массив
                    $id = newRecord("projects", $keysvalues);
                    if ($id != RESULT_ERROR) // всё прошло хорошо
                    {
                        updateFiles($id);
                        exit;
                    }
                }
            }
            else if (($action == "edit") && isset($_SESSION['proj_id']))
            {
                if (updateTableById("projects", $keysvalues, $_SESSION['proj_id']) != RESULT_GOOD)
                {
                    fo_error_msg("Ошибка при записи");
                    exit;
                }
                updateFiles($_SESSION['proj_id']);
                fo_error_msg("Записано успешно!");
                require_once("projectstable.php");
                exit;
            }
        }
        else
        {
            require_once("/index.php");
            exit;
        }
    }
    else // пока форму не отправляли
    {
        if(isset($action))
        {
            if ($action == "new")
            {
                fo_error_msg("0");
                // ничего не делаем, вставим потом
            }
            else if ($action == 'delete')
            {
                deleteFromTableById("projects", $_SESSION['proj_id']);
            }
            // action = edit
            else if ($action == "edit")
            {
                $fields = array(); // empty array
                $keysvalues = array(
                    "id" => $_SESSION['proj_id'],
                );
                $result = getValuesByFieldsOrdered("projects", $fields, $keysvalues);
                if (!$result)
                    exit;
                $row = $result[0];
                $name = $row['name'];
				$cat = $row['cat'];
                $descr = $row['descr'];
                $lat = $row['lat'];
                $log = $row['log'];
                $idcontent = $row['idcontent'];
                $fields = array (
                    'url',
                );
                $keysvalues = array (
                    'projid' => $_SESSION['proj_id'],
                );
                $result = getValuesByFieldsOrdered('projectimages', $fields, $keysvalues);
//                var_dump($result);
                if ($result != RESULT_ERROR)
                {
                    if ($result != RESULT_EMPTY)
                    {
                        foreach($result as $fileurl) {
                            $images[] = $fileurl['url'];
                        }
                    }
                }
                else
                {
                    fo_error_msg("Произошла ошибка");
                    exit;
                }
            }
        }
    }
}
else
{
    fo_error_msg("Не установлены права либо отсутствует action");
    require_once("/index.php");
    exit;
}
?>
<html>
<head>
    <title><?php print $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="/js/map_event.js" type="text/javascript"></script>
	<script src="/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="/js/img_preview.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/css/imgpreview.css">
    <link rel="stylesheet" href="/css/divtable.css">
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
<form action="" method="POST" enctype="multipart/form-data">
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
            <td colspan="3"><input type="number" name="idcontent" value="<?php print isset($idcontent) ? $idcontent : "" ; ?>"></td>
        </tr>
        <tr>
            <td>Фотографии проекта</td>
        </tr>
        <tr>
    </table>
    <br />
    
    <div id="fileinputs">
        <script>
            var fileindex = 0;
        </script>
        <?php $i = 0; foreach($images as $image) : ?>
        <div class="file-form-wrap divtable" id="fileinputdiv<?=$i?>">
            <div class="file-upload">
                <label>
                    <input id="uploaded-file<?=$i?>" type="file" name="image<?=$i?>" onchange="previewImage(<?=$i?>, this.files[0]);" />
                    <span>Выберите файл</span><br />
                </label>
            </div>
            <input name="file-name<?=$i?>" id="file-name<?=$i?>" class="divtablecell" value="<?php print isset($image) ? $image : '' ?>" />
            <div class="divtablecell preview-img"><img class="preview-img" id="imgP<?=$i?>" src="<?php print isset($image) ? 'image.php?filename=' . $image : '' ?>" /></div>
            <div id="file-size<?=$i?>" class="divtablecell">&nbsp;</div>
            <div class="divtablecell"><input type="button" value="Удалить файл" onclick="removeFileInput(<?=$i?>)" /></div>
        </div>
        <br />
        <?php ++$i; endforeach; ?>
    </div>
    <br />
    <script>
        fileindex = '<?= $i ?>';
    </script>
    <input type="button" value="Добавить файл" onclick="addFileInput()"><br />
    <input name="submit" type="submit" value="Submit"><br />
</form>
    <script>window.onload = function() {
            var f = new File(document.getElementById('file-name1').innerHTML);
            previewImage(1, f);
        }
    </script>
    <a href="admin.php">Назад</a>
    <span id="tempout"></span>
    </body>
</html>