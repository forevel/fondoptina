<?php

// require_once "config.php";
session_start();
$link = null;

function db_connect()
{
    global $link;
    $link = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    if (!$link) 
    {
        echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
        echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
}

// http://programmer-weekdays.ru/archives/301

function newUser($login, $password)
{
    global $link;
    $login = mysqli_real_escape_string($link, $login);
    $password = mysqli_real_escape_string($link, $password);
//    echo $password;
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query="INSERT INTO `users` (`user`, `psw`, `rights`) VALUES('$login', '$password', '1')";
//    echo $query;
    $result=mysqli_query($link, $query);
    if (!$result)
    {
        printf("Inserting login info into db failed. Error: %s", mysqli_error($link));
        return false;
    }
    return true;
}

function displayErrors($messages)
{
    print("<b>Возникли следующие ошибки:</b>\n<ul>\n");

    foreach($messages as $msg)
    {
        print("<li>$msg</li>\n");
    }
    print("</ul>\n");
} 

function checkLoggedIn($status)
{
    switch($status)
    {
        case "yes":
            if(!isset($_SESSION["loggedIn"]))
            {
                header("Location: login.php");
                exit;
            }
            break;
        case "no":
            if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true)
            {
                header("Location: members.php");
            }
            break;
    }
    return true;
} 

function checkPass($login, $password)
{
    global $link;

    $login = mysqli_real_escape_string($link, $login);
    $password = mysqli_real_escape_string($link, $password);
//    echo $password;
//    $password = password_hash($password, PASSWORD_DEFAULT);
    $query="SELECT `psw`,`rights` FROM `users` WHERE `user`='$login'";
//    echo $query;
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
//    echo "row=$rowfetched";
//    echo "password=$password";
    if (password_verify($password, $rowfetched)) // совпадают
    {
        $row['user'] = $login;
        return $row;
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

function field_validator($field_descr, $field_data, $field_type, $min_length="", $max_length="", $field_required=1)
{
    global $messages;
    if(!$field_data && !$field_required){ return; }

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
        $messages[] = "Поле $field_descr является обязательным";
        return;
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
        $messages[] = "Введённый $field_descr не удовлетворяет правилам ввода";
        return;
    }

    if ($field_ok && ($min_length > 0))
    {
        if (strlen($field_data) < $min_length)
        {
            $messages[] = "$field_descr не должен быть короче $min_length символов";
            return;
        }
    }

    if ($field_ok && ($max_length > 0))
    {
        if (strlen($field_data) > $max_length)
        {
            $messages[] = "$field_descr не должен быть длиннее $max_length символов";
            return;
        }
    }
}

function get_table_from_db($table)
{
    global $link;
    
    $query = "SELECT * FROM `$table`";
    $result = mysqli_query($link, $query);
    
    if (!$result)
    {
        printf("Selecting projects failed. Error: %s", mysqli_error($link));
        return false;
    }    
    $n = mysqli_num_rows($result);
    $retvalue = array();
    
    for ($i=0; $i<$n; $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $retvalue[] = $row;
    }
    return $retvalue;
}


function db_disconnect()
{
    global $link;
    mysqli_close($link);
}

?>