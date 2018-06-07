<?php
define('MYSQL_SERVER', 'localhost');
define('MYSQL_USER', 'cr42072_0');
define('MYSQL_PASSWORD', 'bIt*rAD()');
define('MYSQL_DB', 'cr42072_0');
define('RESULT_GOOD', 0);
define('RESULT_ERROR', -1);
define('RESULT_EMPTY', -2);
define('UPLOAD_FILE_MAX',10);
//define('DEFLAT', '54.03482');
//define('DEFLOG', '35.78226');
require_once("database.php");
require_once("functions.php");
dbConnect();
?>