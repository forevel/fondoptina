<?php
require_once(__DIR__ . "/config.php");

$title="Страница авторизации";
// fo_error_msg("login started");
if(isset($_POST["submit"]))
{
    field_validator("login name", $_POST["login"], "alphanumeric", 4, 15);
    field_validator("password", $_POST["password"], "string", 4, 15);

    $row = checkPass($_POST["login"], $_POST["password"]);
	if ($row != RESULT_ERROR)
    {
		cleanMemberSession($row[0]['user'], $row[0]['psw'], $row[0]['rights']);
/*        fo_error_msg($_SESSION['rights']);
        fo_error_msg($_SESSION['loggedIn']); */
		require_once(__DIR__ . "/../admin/index.php");
        exit;
    }
}
if(isset($_SESSION['rights']))
{
    require_once(__DIR__ . '/../admin/index.php');
    exit;
}

?>
<html>
<head>
<title><?php print $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<h1><?php print $title; ?></h1>
<form action="" method="POST">
<table>
<tr><td>Логин:</td><td><input type="text" name="login"
value="<?php print isset($_POST["login"]) ? $_POST["login"] : "" ; ?>"
maxlength="15"></td></tr>
<tr><td>Пароль:</td><td><input type="password" name="password" value="" maxlength="15"></td></tr>
<tr><td>&nbsp;</td><td><input name="submit" type="submit" value="Submit"></td></tr>
</table>
</form>
</body>
</html>
<?php
//}
?>