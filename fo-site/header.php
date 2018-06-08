<?php
require_once("inc/f_main.php");

if (isset($pagename))
{
    $fields = [
        'title',
        'contents',
    ];
    $indexedresult = getPageByName($pagename, $fields);
    $title = $indexedresult['title'];
}
// else $title задаётся из вызывающего файла


$fields = [
    'title', // picture
    'contents', // text
];
$indexedresult = getPageByName('header', $fields);
$headerimage = '/img/header/' . $indexedresult['title'];
$header = $indexedresult['contents'];

require_once("tpl/header.html");

require_once("menu.php");
?>