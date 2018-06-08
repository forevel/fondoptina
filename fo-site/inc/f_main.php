<?php
require_once (__DIR__ . "/config.php");
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
?>