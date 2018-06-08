<?php
/* Редактирование проектов */
require_once(__DIR__ . "/../inc/f_files.php");

$title="Редактор проектов";
$images = array();
$projid = $_GET['id'];
// $_SESSION['projid'] = $projid;
if (isset($_GET['action']))
{
    $projaction = $_GET['action'];
    //    $_SESSION['proj_action'] = $projaction;
    //    if (($projaction == "edit") && (isset($projid)))
    //        $_SESSION['proj_id'] = $_GET['id'];
    // считать права доступа к сайту через SESSION
    if(isset($_SESSION["rights"]))
    {
    //    $action = $_SESSION['proj_action'];
        if (isset($_POST["submit"]))
        {
            if (isset($_POST["name"]))
            {
    //            $projid = $_SESSION['proj_id'];
                $keysvalues = array(
                    "name" => $_POST["name"],
                    "title" => $_POST["name"],
                    "descr" => $_POST["name"],
                    "cat" => $_POST["cat"],
                    "content" => $_POST["content"],
                    "lat" => $_POST["lat"],
                    "log" => $_POST["log"],
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
                        $projid = newRecord("projects", $keysvalues);
                        if ($projid != RESULT_ERROR) // всё прошло хорошо
                        {
                            updateFiles("projectpic", "idproj", $projid);
                        }
                    }
                }
                else if (($projaction == "edit") && isset($projid))
                {
                    if (updateTableById("projects", $keysvalues, $projid) != RESULT_GOOD)
                    {
                        fo_error_msg("Ошибка при записи");
                        exit;
                    }
                    updateFiles("projectpic", "idproj", $projid);
                }
                // обновляем меню
                // ищем пункт меню "Проекты" и берём его id
                $result = getValuesByFieldsOrdered("menu", array('id'), array('name' => 'Проекты'));
                $projmenuid = '0';
                if (($result != RESULT_ERROR) && ($result != RESULT_EMPTY))
                {
                    $projmenuid = $result[0]['id'];
                }
                else
                {
                    fo_error_msg("Ошибка обновления меню");
                    require_once(__DIR__ . "/projectstable.php");
                    exit;
                }
                // сначала поиск id, у которого name = $_POST['name']
                $fields = [
                    'id',
                ];
                $keysvalues = [
                    'name' => $_POST['name'],
                    'idalias' => $projmenuid,
                ];
                $result = getValuesByFieldsOrdered("menu", $fields, $keysvalues);
                // если нету, то добавление
                if ($result == RESULT_EMPTY)
                {
                    // создаём массив c keysvalues, заданными ранее
//                    var_dump($projid);
                    $keysvalues = [
                        'name' => $_POST['name'],
                        'idalias' => $projmenuid,
                        'url' => 'projectpage.php?id='.$projid,
                    ];
                    $id = newRecord("menu", $keysvalues);
                    if ($id == RESULT_ERROR)
                    {
                        fo_error_msg("Ошибка добавления пункта меню");
                        require_once(__DIR__ . "/projectstable.php");
                        exit;
                    }
                }
                fo_error_msg("Записано успешно!");
                require_once(__DIR__ . "/projectstable.php");
                exit;
            }
            else
            {
                require_once(__DIR__ . "/index.php");
                exit;
            }
        }
        else // пока форму не отправляли
        {
            if(isset($projaction))
            {
                if ($projaction == "new")
                {
                    fo_error_msg("0");
                    // ничего не делаем, вставим потом
                }
                else if (($projaction == 'delete') && isset($projid))
                {
                    deleteFromTableById("projects", $projid);
                    fo_error_msg("Удалено успешно!");
                    require_once(__DIR__ . "/projectstable.php");
                    exit;
                }
                // action = edit
                else if ($projaction == "edit")
                {
                    $fields = array(); // empty array
                    $keysvalues = array(
                        "id" => $projid,
                    );
                    $result = getValuesByFieldsOrdered("projects", $fields, $keysvalues);
                    if (!$result)
                        exit;
                    $row = $result[0];
                    $name = $row['name'];
                    $cat = $row['cat'];
                    $descr = $row['descr'];
                    $title = $row['title'];
                    $lat = $row['lat'];
                    $log = $row['log'];
                    $content = $row['content'];
                    // вставить сюда потом чтение меню и поиск id элемента, у которого name
                    // далее запись в базу по этому id
                    $fields = array (
                        'url',
                    );
                    $keysvalues = array (
                        'projid' => $projid,
                    );
                    $result = getValuesByFieldsOrdered('projectpic', $fields, $keysvalues);
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
}
else
{
    fo_error_msg("Не установлены права либо отсутствует action");
    fo_error_msg($_SESSION['rights']."__".$_GET['action']);
    require_once(__DIR__ . "/index.php");
    exit;
}
?>
<html>
<head>
    <title><?php print $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<!--	<script src="/js/jquery-3.2.1.min.js" type="text/javascript"></script> -->
    <script src="/js/img_preview.js" type="text/javascript"></script>
    <script src="/js/map_event.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/css/imgpreview.css">
    <link rel="stylesheet" href="/css/divtable.css">
    <link rel="stylesheet" href="/css/map.css">
</head>
<body>
<h1><?php print $title; ?></h1>
<div id='yamap'></div>
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
            <td colspan="3"><textarea class="textarea300" name="content"><?php print isset($content) ? $content : ""; ?></textarea></td>
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
                    <input id="projectpic<?=$i?>" type="file" name="projectpic<?=$i?>" onchange="previewImage('projectpic<?=$i?>', this.files[0]);" />
                    <span>Выберите файл</span><br />
                </label>
            </div>
            <input name="projectpic<?=$i?>_name" id="projectpic<?=$i?>_name" class="divtablecell" value="<?php print isset($image) ? $image : '' ?>" />
            <div class="divtablecell preview-img"><img class="preview-img" id="projectpic<?=$i?>_preview" src="<?php print isset($image) ? 'image.php?filename=' . $image : '' ?>" /></div>
            <div id="projectpic<?=$i?>_size" class="divtablecell">&nbsp;</div>
            <div class="divtablecell"><input type="button" value="Удалить файл" onclick="removeFileInput(<?=$i?>)" /></div>
        </div>
        <br />
        <?php ++$i; endforeach; ?>
    </div>
    <br />
    <script>
        fileindex = '<?= $i ?>';
    </script>
    <input type="button" value="Добавить файл" onclick="addFileInput(UPLOAD_FILE_MAX)"><br />
    <input name="submit" type="submit" value="Отправить в базу"><br />
</form>
        
    <?php
        $fields = [
                            'url',
        ];
        $keysvalues = [
                            'idcat' => $cat,
        ];
        $result = getValuesByFieldsOrdered('symbolpics', $fields, $keysvalues);
        $pic = '';
        if ($result != RESULT_ERROR)
        {
            if ($result != RESULT_EMPTY)
            {
                $pic = $result[0]['url'];
            }
        }
        $scriptpic = __DIR__ . "/../upload/". $pic;
    ?>
    <a href="projectstable.php">Назад</a>
    <span id="tempout"></span>
    </body>
</html>