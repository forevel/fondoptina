<?php
require_once("inc/config.php");

$fields = [
    'title',
    'contents',
];

if (isset($pagename))
    $indexedresult = getPageByName($pagename, $fields);
else
    $indexedresult = getPageByName('main', $fields);

$title = $indexedresult['title'];

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