<?php
/* Редактирование проектов */
require_once(__DIR__ . "/../inc/config.php");
require_once(__DIR__ . "/../inc/f_images.php");
require_once(__DIR__ . "/../inc/f_files.php");

$title="Редактор работ";
$images = array();
$workpostfile = __DIR__.'/workpost.php';

if (isset($_GET['action']))
{
    $workaction = $_GET['action'];
    $workid = $_GET['id'];
}

// считать права доступа к сайту через SESSION
if (isset($_SESSION["rights"]))
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
                "deleted" => "0",
            );
            $result = getValuesByFieldsOrdered("works", $fields, $keysvalues);
            if (!$result)
                exit;
            $row = $result[0];
            $name = $row['name'];
            $idprojects = $row['idprojects'];
            $descr = $row['descr'];
            $moneyneed = $row['moneyneed'];
            $moneygot = $row['moneygot'];
            $workprogress = $row['workprogress'];
            $moneystarted = $row['moneystarted'];
            $moneyfinished = $row['moneyfinished'];
            $workstarted = $row['workstarted'];
            $workfinished = $row['workfinished'];
            $pic = $row['pic'];
            $picfull = $row['picfull'];
            $fields = array (
                'url',
            );
            $keysvalues = array (
                'idwork' => $workid,
                "deleted" => "0",
            );
//                var_dump($keysvalues);
            $result = getValuesByFieldsOrdered('workpic', $fields, $keysvalues);
//                var_dump($result);
            if ($result != RESULT_ERROR)
            {
                if ($result != RESULT_EMPTY)
                {
                    foreach($result as $fileurl) {
                        $images[] = $fileurl['url'];
                    }
                }
/*                else
                {
                    fo_error_msg("Результат пустой");
                } */
            }
            else
            {
                fo_error_msg("Произошла ошибка при получении данных по workpic");
                exit;
            }
        }
        else
        {
            fo_error_msg("Не установлен action");
            require_once("index.php");
            exit;
        }
    }
}
else
{
    fo_error_msg("Не установлены права");
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
<h1>Проект: <?php print (isset($projectname)) ? $projectname : "неизвестно"; ?></h1>
<form action="workpost.php" method="POST" enctype="multipart/form-data">
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
            <td>Главная фотография работы<br />
                <div class="file-form-wrap divtable" id="fileinputdiv0">
                    <div class="file-upload">
                        <label>
                            <input type="file" name="mainpic" onchange="previewImage('mainpic', this.files[0]);" />
                            <span>Выберите файл</span><br />
                        </label>
                    </div>
                    <input name="mainpic_name" id="mainpic_name" class="divtablecell" value="<?php print isset($picfull) ? $picfull : '' ?>" />
                    <div class="divtablecell preview-img"><img class="preview-img" id="mainpic_preview" src="<?php print isset($picfull) ? 'image.php?filename=' . $picfull : '' ?>" /></div>
                    <div id="mainpic_size" class="divtablecell">&nbsp;</div>
                </div>
            </td>
        </tr>
        <tr>
            <td>Фотографии к работе</td>
        </tr>
    </table>
    <div id="fileinputs">
        <script>
            var fileindex = 0; // для функций img_preview
        </script>
        <?php $i = 1; foreach($images as $image) : ?>
        <div class="file-form-wrap divtable" id="fileinputdiv<?=$i?>">
            <div class="file-upload">
                <label>
                    <input id="workpic<?=$i?>" type="file" name="workpic<?=$i?>" onchange="previewImage('workpic<?=$i?>', this.files[0]);" />
                    <span>Выберите файл</span><br />
                </label>
            </div>
            <input name="workpic<?=$i?>_name" id="workpic<?=$i?>_name" class="divtablecell" value="<?php print isset($image) ? $image : '' ?>" />
            <div class="divtablecell preview-img"><img class="preview-img" id="workpic<?=$i?>_preview" src="<?php print isset($image) ? 'image.php?filename=' . $image : '' ?>" /></div>
            <div id="workpic<?=$i?>_size" class="divtablecell">&nbsp;</div>
            <div class="divtablecell"><input type="button" value="Удалить файл" onclick="removeFileInput(<?=$i?>)" /></div>
        </div>
        <br />
        <?php ++$i; endforeach; ?>
    </div>
    <br />
    <script>
        fileindex = '<?= $i ?>';
    </script>
    <input type="button" value="Добавить файл" onclick="addFileInput(<?=UPLOAD_FILE_MAX?>)"><br />
    <input name="submit" type="submit" value="Отправить в базу данных"><br />
    <input type="hidden" name="workaction" value="<?=$workaction?>">
    <input type="hidden" name="projid" value="<?=$idprojects?>">
    <input type="hidden" name="workid" value="<?=$workid?>">
</form>
    <a href="workstable.php?id=<?=$idprojects?>">Назад</a>
    <span id="tempout"></span>
    </body>
</html>