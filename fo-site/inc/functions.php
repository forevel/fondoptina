<?php
session_start();

function checkPass($login, $password)
{
    $fields = array(
        'psw',
        'rights',
    );
    $keysvalues = array(
        'user' => $login,
    );
    $result = getValuesByFieldsOrdered('users', $fields, $keysvalues);
    if (($result == RESULT_ERROR) || ($result == RESULT_EMPTY))
        return $result;

    $rowfetched=$result[0]['psw'];
    if (password_verify($password, $rowfetched)) // совпадают
    {
        $result[0]['user'] = $login;
        return $result;
    }
    fo_error_msg("Login failed");
    return RESULT_ERROR;
} 

function checkLoggedIn()
{
    if(!isset($_SESSION["loggedIn"]))
        return false;
    if(isset($_SESSION["loggedIn"]))
    {
        if ($_SESSION["loggedIn"] === true)
            return true;
    }
    return false;
} 

function cleanMemberSession($login, $password, $rights)
{
    $_SESSION["login"]=$login;
    $_SESSION["password"]=$password;
    $_SESSION["rights"]=$rights;
    $_SESSION["loggedIn"]=true;
} 

function flushMemberSession()
{
    unset($_SESSION["login"]);
    unset($_SESSION["password"]);
    unset($_SESSION["rights"]);
    unset($_SESSION["loggedIn"]);
    session_destroy();
    return true;
} 

function getPageByName($pagename, $fields)
{
    $keysvalues = [
        'pagename' => $pagename,
        'deleted'  => '0',
    ];

//    var_dump($fields);
    $result = getValuesByFieldsOrdered('staticpages', $fields, $keysvalues);
    if ($result == RESULT_ERROR)
    {
        fo_error_msg("Ошибка получения данных по странице $pagename");
        exit;
    }

    return $result[0];
}

function getMenuitemByIdalias($id)
{
    $fields = [
        'id',
        'name',
        'url',
    ];
    $keysvalues = [
        'idalias' => $id,
    ];
    $orderby = [
        'order',
        'ASC',
    ];

    $menu = getValuesByFieldsOrdered('menu', $fields, $keysvalues, $orderby);
    if ($menu == RESULT_ERROR)
    {
        fo_error_msg("Ошибка получения данных по меню");
        exit;
    }
    return $menu;
}

function field_validator($field_descr, $field_data, $field_type, $min_length="", $max_length="", $field_required=1)
{
    global $messages;
    if(!$field_data && !$field_required)
        return;

    $field_ok=false;

    $email_regexp="/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|";
    $email_regexp.="(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";

    $data_types=array(
        "email"=>$email_regexp,
        "digit"=>"/^[0-9]$/",
        "number"=>"/^[0-9]+$/",
        "alpha"=>"/^[a-zA-Z]+$/",
        "alpha_space"=>"/^[a-zA-Z ]+$/",
        "alphanumeric"=>"/^[a-zA-Z0-9]+$/",
        "alphanumeric_space"=>"/^[a-zA-Z0-9 ]+$/",
        "string"=>"^$"
    );

    if ($field_required && empty($field_data))
    {
        fo_error_msg("Поле $field_descr является обязательным");
        return RESULT_ERROR;
    }

    if ($field_type == "string")
    {
        $field_ok = true;
    }
    else
    {
        $field_ok = preg_match($data_types[$field_type], $field_data);
    }

    if (!$field_ok) 
    {
        fo_error_msg("Введённый $field_descr не удовлетворяет правилам ввода");
        return RESULT_ERROR;
    }

    if ($field_ok && ($min_length > 0))
    {
        if (strlen($field_data) < $min_length)
        {
            fo_error_msg("$field_descr не должен быть короче $min_length символов");
            return RESULT_ERROR;
        }
    }

    if ($field_ok && ($max_length > 0))
    {
        if (strlen($field_data) > $max_length)
        {
            fo_error_msg("$field_descr не должен быть длиннее $max_length символов");
            return RESULT_ERROR;
        }
    }
    return RESULT_GOOD;
}

function fo_error_msg($errormsg)
{
    echo "<script type=\"text/javascript\">window.alert(\"".$errormsg."\");</script>";
}

function createDirAndChange($dir)
{
    if (!is_dir($dir))
    {
        mkdir($dir, 0777, true);
    }
    chdir($dir);
}

function uploadFile($file)
{
//    fo_error_msg($file['name']);
    if (empty($file['name']))
    {
//        fo_error_msg("Пустое имя файла");
        return RESULT_ERROR;
    }
    if (!is_file($file['name'])) // нет файла, создаём...
    {
        // создаём каталог...
        $objDateTime = new DateTime('NOW');
        $dir = __DIR__ . "/../upload/" . date_format($objDateTime, "y");
        createDirAndChange($dir);
        $dir .= "/" . date_format($objDateTime, "m");
        createDirAndChange($dir);
        $dir .= "/" . date_format($objDateTime, "d");
        createDirAndChange($dir);
        // загружаем файл...
        $filename = $file['name'];
        $filesize = $file['size'];
        $filetmp = $file['tmp_name'];
        $filetype = $file['type'];
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
                move_uploaded_file($filetmp, "./" . $filename);
                $filename = "upload/" . date_format($objDateTime, "y") . "/" . date_format($objDateTime, "m") . "/" . date_format($objDateTime, "d") . "/" . $filename;
                return $filename;
            }
        }
        else
        {
            fo_error_msg("not allowed extension");
            return RESULT_ERROR;
        }
    }
}

?>