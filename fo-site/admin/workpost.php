<?php
/* Редактирование проектов */
require_once(__DIR__ . "/../inc/config.php");
require_once(__DIR__ . "/../inc/images.php");
require_once(__DIR__ . "/../inc/files.php");

$images = array();

// echo '#0#';
$workaction = $_POST['workaction'];
$workid = $_POST['workid'];
// считать права доступа к сайту через SESSION
if (isset($_POST["submit"]))
{
    if (isset($_POST["name"]))
    {
        $keysvalues = array(
            "name" => $_POST["name"],
            "idprojects" => $_POST['projid'],
            "descr" => $_POST["descr"],
            "moneyneed" => $_POST["moneyneed"],
            "moneygot" => $_POST["moneygot"],
            "workprogress" => $_POST["workprogress"],
            "moneystarted" => $_POST["moneystarted"],
            "moneyfinished" => $_POST["moneyfinished"],
            "workstarted" => $_POST["workstarted"],
            "workfinished" => $_POST["workfinished"],
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
        }
        updateFiles($workid);
        if (isset($_POST['mainpic_name'])) $mainpic_name = $_POST['mainpic_name'];
        if (($newfilename = uploadFile($_FILES['mainpic'], $mainpic_name)) != RESULT_ERROR)
        {
            $path_parts = pathinfo($newfilename);
//                        var_dump($path_parts);
            $newsmallfilename = $path_parts['filename']."_small.".$path_parts['extension'];
//            var_dump($newsmallfilename);
            image_resize(__DIR__."/../".$newfilename, __DIR__."/../tmp/".$newsmallfilename,100);
            /* create dir in format: ../upload/yyyy/mm/dd and change into it */
            createUploadDir(); 
            rename(__DIR__."/../tmp/".$newsmallfilename, "./" . $newsmallfilename);
            $keysvalues['pic'] = $newsmallfilename;
            $keysvalues['picfull'] = $newfilename;
        }
        if ($workaction == "new")
        {
            $workid = newRecord("works", $keysvalues);
            if ($workid != RESULT_ERROR) // всё прошло хорошо
            {
                fo_error_msg("Записано успешно!");
                $id = $_SESSION['projid'];
                require_once("workstable.php");
                exit;
            }
        }
        else if (($workaction == "edit") && isset($workid))
        {
            if (updateTableById("works", $keysvalues, $workid) != RESULT_GOOD)
            {
                fo_error_msg("Ошибка при записи");
                exit;
            }
            fo_error_msg("Записано успешно!");
            $id = $_SESSION['projid'];
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
else
{
    fo_error_msg("Не дан метод POST");
    exit;
}
?>
