<?php
require_once (__DIR__ . "/f_main.php");
function createDirAndChange($dir)
{
    if (!is_dir($dir))
    {
        mkdir($dir, 0777, true);
    }
    chdir($dir);
}

function createUploadDir()
{
    // создаём каталог...
    $objDateTime = new DateTime('NOW');
    $dir = __DIR__ . "/../upload/" . date_format($objDateTime, "y");
    createDirAndChange($dir);
    $dir .= "/" . date_format($objDateTime, "m");
    createDirAndChange($dir);
    $dir .= "/" . date_format($objDateTime, "d");
    createDirAndChange($dir);
}

function uploadFile($file, $filename)
{
/*    echo '#4#';
    var_dump($file);
    echo $filename;
    echo '<br />'; */
    if (empty($file['name'])) // there was something choosed
    {
        return $filename; // returning previous filename
    }
    if (!is_file($file['name'])) // нет файла, создаём...
    {
        createUploadDir();
        // загружаем файл...
        $filename = $file['name'];
        $filesize = $file['size'];
        $filetmp = $file['tmp_name'];
        $tmp = explode('.', $filename);
        $fileext = strtolower(end($tmp));
        $allowedexts = array("jpeg","jpg","png","gif");
        if (in_array($fileext, $allowedexts))
        {
            if ($filesize > 10000000)
            {
                fo_error_msg("file size exceeds 10M");
                return RESULT_ERROR;
            }
            else
            {
/*                var_dump($filetmp);
                echo '@';
                var_dump($filename);
                echo '@'; */
                $returncode = move_uploaded_file($filetmp, "./" . $filename);
                if (!$returncode)
                {
                    fo_error_msg("Ошибка при загрузке файла");
                }
//                var_dump($returncode);
                $objDateTime = new DateTime('NOW');
                $filename = "upload/" . date_format($objDateTime, "y") . "/" . date_format($objDateTime, "m") . "/" . date_format($objDateTime, "d") . "/" . $filename;
//                echo '#5#';
//                var_dump($filename); 
                return $filename;
            }
        }
        else
        {
            fo_error_msg("not allowed extension");
            return RESULT_ERROR;
        }
    }
    else
    {
        return $file['name'];
    }
}

/* function to update files on the server - check its existence and upload
 * if nothing has been found
 * input: $template - in the form: "<template><index>'_name'" is the input field
 * where the name of the file located
 * $idname - is a field string that is compared to $id
 * $id - is an id of the current work
 */
function updateFiles($template, $idname, $id)
{
//    echo '#2#';
    // очищаем базу от старых записей о картинках
    if (isset($id))
    {
        deleteFromTable($template, $idname, $id, 1); // real delete
        // теперь пишем картинки в базу
        for ($i=1; $i<UPLOAD_FILE_MAX; $i++)
        {
            if (isset($_POST[$template.$i.'_name']))
            {
                $filename = $_POST[$template.$i.'_name'];
            }
            else
            {
                continue;
            }
            if (($newfilename = uploadFile($_FILES[$template.$i], $filename)) != RESULT_ERROR)
            {
/*                echo '#3#';
                var_dump($newfilename); */
                $keysvalues = array(
                    'url' => $newfilename,
                    $idname => $id,
                );
                newRecord($template, $keysvalues);
            }
        }
    }
    else
    {
        fo_error_msg("Не задан ИД");
    }
}
?>