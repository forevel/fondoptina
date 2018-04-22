<?php
$file = $_GET['filename'];
header("Content-type: image/jpeg");
$im=imageCreateFromJPEG(__DIR__ . '/../fo-site/' . $file);
imageJPEG($im);
?>