<?php
/* Функции для добавления новых пользователей в систему */

require_once(__DIR__ . "/f_main.php");

$check = checkLoggedIn();
if (!$check)
    exit;

$title="страница регистрации";

if(isset($_POST["submit"]))
{
    field_validator("login name", $_POST["login"], "alphanumeric", 4, 15);
    field_validator("password", $_POST["password"], "string", 4, 15);
    field_validator("confirmation password", $_POST["password2"], "string", 4, 15);

    if(strcmp($_POST["password"], $_POST["password2"]))
    {
        $messages[]="Ваши пароли не совпадают";
    }
    
    $query="SELECT `user` FROM `users` WHERE `user`='".$_POST["login"]."'";

    $result=mysqli_query($link,$query);
    if (!$result)
    {
        printf("Selecting login info failed. Error: %s", mysqli_error($link));
        return false;
    }

    if( ($row=mysqli_fetch_assoc($result)) )
    {
        $messages[]="Логин \"".$_POST["login"]."\" уже занят, попробуйте другой";
    }

    if(empty($messages))
    {
        newUser($_POST["login"], $_POST["password"]);
        cleanMemberSession($_POST["login"], $_POST["password"], '1');
        header("Location: members.php");
    }
}
?>
<html>
<head>
<title><?php print $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<h1><?php print $title; ?></h1>
<?php
if(!empty($messages)){
  displayErrors($messages);
}
?>
<form action="<?php print $_SERVER['PHP_SELF']; ?>" method="POST">
<table>
<tr><td>Логин:</td><td><input type="text" name="login"
value="<?php print isset($_POST["login"]) ? $_POST["login"] : "" ; ?>"
maxlength="15"></td></tr>
<tr><td>Пароль:</td><td><input type="password" name="password" value="" maxlength="15"></td></tr>
<tr><td>Повторить пароль:</td><td><input type="password" name="password2" value="" maxlength="15"></td></tr>
<tr><td>&nbsp;</td><td><input name="submit" type="submit" value="Submit"></td></tr>
</table>
</form>
</body>
</html>