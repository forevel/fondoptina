<?php
/* Редактирование проектов */
require_once(__DIR__ . "/../inc/config.php");

function updateFiles($id)
{
    // очищаем базу от старых записей о картинках
    deleteFromTable('workpics', 'idwork', $id);
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
                'idwork' => $id,
            );
            newRecord('workpics', $keysvalues);
        }
    }
    // теперь пишем картинки в базу
//    var_dump($_FILES);
    foreach($_FILES as $file) {
        if (($newfilename = uploadFile($file)) != RESULT_ERROR)
        {
            $keysvalues = array(
                'url' => $newfilename,
                'idwork' => $id,
            );
            newRecord('workpics', $keysvalues);
        }
    }
}

$title="Редактор работ";
$images = array();
$workid = $id;

if (isset($_GET['action']))
{
    $workaction = $_GET['action'];
}

// считать права доступа к сайту через SESSION
if((isset($_SESSION["rights"])) && (isset($workaction)))
{
    if (isset($_POST["submit"]))
    {
        if (isset($_POST["name"]))
        {
            $keysvalues = array(
                "name" => $_POST["name"],
                "idprojects" => $_POST["idprojects"],
                "descr" => $_POST["descr"],
                "moneyneed" => $_POST["moneyneed"],
                "moneygot" => $_POST["moneygot"],
                "workprogress" => $_POST["workprogress"],
                "moneystarted" => $_POST["moneystarted"],
                "moneyfinished" => $_POST["moneyfinished"],
                "workstarted" => $_POST["workstarted"],
                "workfinished" => $_POST["workfinished"],
                "pic" => $_POST["pic"],
                "picfull" => $_POST["picfull"],
            );

            if ($workaction == "new")
            {
                $row = getValuesByFieldsOrdered("works", array('name'), array('name' => $_POST['name']));

                if ($row == RESULT_ERROR)
                {
                    fo_error_msg("Selecting info failed. Error: ".mysqli_error($link));
                    exit;
                }
                if ($row != RESULT_EMPTY) // there's already this name in db
                {
                    fo_error_msg("Работа \"".$_POST["name"]."\" уже имеется, попробуйте другую");
                    exit;
                }
                else
                {
                    // создаём массив
                    $workid = newRecord("works", $keysvalues);
                    if ($workid != RESULT_ERROR) // всё прошло хорошо
                    {
                        updateFiles($workid);
                        exit;
                    }
                }
            }
            else if (($workaction == "edit") && isset($workid))
            {
                if (updateTableById("works", $keysvalues, $workid) != RESULT_GOOD)
                {
                    fo_error_msg("Ошибка при записи");
                    exit;
                }
                updateFiles($workid);
                fo_error_msg("Записано успешно!");
                require_once("workstable.php");
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
        if(isset($workaction))
        {
            if ($workaction == "new")
            {
                fo_error_msg("0");
                // ничего не делаем, вставим потом
            }
            else if (($workaction == 'delete') && isset($workid))
            {
                deleteFromTableById("works", $workid);
            }
            // action = edit
            else if (($workaction == "edit") && isset($workid))
            {
                $fields = array(); // empty array
                $keysvalues = array(
                    "id" => $workid,
                );
                $result = getValuesByFieldsOrdered("works", $fields, $keysvalues);
                if (!$result)
                    exit;
                $row = $result[0];
                $name = $row['name'];
                $idprojects = $row['idprojects'],
                $descr => $row['descr'],
                $moneyneed => $_POST['moneyneed'],
                $moneygot => $_POST['moneygot'],
                $workprogress => $_POST['workprogress'],
                $moneystarted => $_POST['moneystarted'],
                $moneyfinished => $_POST['moneyfinished'],
                $workstarted => $_POST['workstarted'],
                $workfinished => $_POST['workfinished'],
                $pic => $_POST['pic'],
                $picfull => $_POST['picfull'],
                $fields = array (
                    'url',
                );
                $keysvalues = array (
                    'idworks' => $workid,
                );
                $result = getValuesByFieldsOrdered('workpics', $fields, $keysvalues);
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
    require_once("index.php");
    exit;
}
if (isset($idprojects))
{
    $result = getValuesByFieldsOrdered('projects', array('name'), array('id' => $idprojects));
    if (($result != RESULT_ERROR) && ($result != RESULT_EMPTY))
        $projectname = $result[0]['name'];
}
?>
<html>
<head>
    <title><?php print $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="/js/img_preview.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/css/imgpreview.css">
    <link rel="stylesheet" href="/css/divtable.css">
</head>
<body>
<h1>Проект: <?php print (isset($projectname)) ? $projectname : "неизвестно"; } ?></h1>
<form action="" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Наименование работы:</td>
            <td><input type="text" name="name" value="<?php print isset($name) ? $name : "" ; ?>"></td>
        </tr>
        <tr>
            <td>Требуется денег:</td>
            <td><input id="moneyneed" name="moneyneed" value="<?php print isset($moneyneed) ? $moneyneed : ""; ?>"></td>
        </tr>
        <tr>
            <td>Собрано денег:</td>
            <td><input id="moneygot" name="moneygot" value="<?php print isset($moneygot) ? $moneygot : ""; ?>"></td>
        </tr>
        <tr>
            <td>Работа выполнена на</td>
            <td><input id="workprogress" name="workprogress" value="<?php print isset($workprogress) ? $workprogress : ""; ?>"></td>
            <td>процентов</td>
        </tr>
        <tr>
            <td>Начали собирать (дата):</td>
            <td><input type="date" id="moneystarted" name="moneystarted" value="<?php print isset($moneystarted) ? $moneystarted : ""; ?>"></td>
        </tr>
        <tr>
            <td>Закончили собирать (дата):</td>
            <td><input type="date" id="moneyfinished" name="moneyfinished" value="<?php print isset($moneyfinished) ? $moneyfinished : ""; ?>"></td>
        </tr>
        <tr>
            <td>Работы начаты (дата):</td>
            <td><input type="date" id="workstarted" name="workstarted" value="<?php print isset($workstarted) ? $workstarted : ""; ?>"></td>
        </tr>
        <tr>
            <td>Работы закончены (дата):</td>
            <td><input type="date" id="workfinished" name="workfinished" value="<?php print isset($workfinished) ? $workfinished : ""; ?>"></td>
        </tr>
        <tr>
            <td>Описание работы</td>
            <td colspan="3"><textarea name="descr"><?php print isset($descr) ? $descr : ""; ?></textarea></td>
        </tr>
        <tr>
            <td>Фотографии проекта</td>
        </tr>
    </table>
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
    <a href="workstable.php">Назад</a>
    <span id="tempout"></span>
    </body>
</html>