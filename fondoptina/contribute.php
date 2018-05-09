<?php

if (isset($_GET['id']))
{
    $id = $_GET['id'];
    echo $id;
    require_once(__DIR__ . "/../fo-site/contribute.php");
} 
echo "12345";
?>