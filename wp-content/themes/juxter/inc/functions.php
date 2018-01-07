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
    $result = get_table_from_db_with_conditions('users', $fields, $keysvalues);
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
    
    /*    global $link;

    $login = mysqli_real_escape_string($link, $login);
    $password = mysqli_real_escape_string($link, $password);
    $query="SELECT `psw`,`rights` FROM `users` WHERE `user`='$login'";
    $result=mysqli_query($link, $query);
    if (!$result)
    {
        printf("Checking login info failed. Error: %s", mysqli_error($link));
        return false;
    }
    if(mysqli_num_rows($result)<1)
    {
        $messages[] = "Empty select psw result";
        return false;
    }
    $row = mysqli_fetch_assoc($result);
    $rowfetched=$row['psw'];
    if (password_verify($password, $rowfetched)) // совпадают
    {
        $row['user'] = $login;
        return $row;
    }
    return false; */
} 

function checkLoggedIn($status)
{
    switch($status)
    {
        case "yes":
            if(!isset($_SESSION["loggedIn"]))
            {
                fo_redirect("login.php");
                exit;
            }
            break;
        case "no":
            if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true)
            {
                fo_redirect("members.php");
            }
            break;
    }
    return true;
} 

/*function displayErrors($messages)
{
    print("<b>Возникли следующие ошибки:</b>\n<ul>\n");

    foreach($messages as $msg)
    {
        print("<li>$msg</li>\n");
    }
    print("</ul>\n");
}  */

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

function fo_redirect($url)
{
    echo "<script type=\"text/javascript\">window.location=\"".$url."\";</script>";
}
?>