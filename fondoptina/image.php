<?php
$file = $_GET['filename'];
header("Content-type: image/jpeg");
$im=imagecreatefromjpeg(__DIR__ . '/../fo-site/' . $file);
imagejpeg($im);
?>