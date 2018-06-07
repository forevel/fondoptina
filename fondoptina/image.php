<?php
$file = __DIR__ . '/../fo-site/' . $_GET['filename'];
$type = exif_imagetype($file);
if ($type)
{
    switch ($type)
    {
        case IMAGETYPE_JPEG:
            header("Content-type: image/jpeg");
            $im=imagecreatefromjpeg($file);
            imagejpeg($im);
            break;
        case IMAGETYPE_GIF:
            header("Content-type: image/gif");
            $im=imagecreatefromgif($file);
            imagegif($im);
            break;
        case IMAGETYPE_PNG:
            header("Content-type: image/png");
            $im=imagecreatefrompng($file);
            imagepng($im);
            break;
        default:
            break;
    }
}
?>