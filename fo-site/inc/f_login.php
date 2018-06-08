<?php
require_once("f_main.php");

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
?>