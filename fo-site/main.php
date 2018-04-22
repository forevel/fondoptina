<?php
$indexedresult = getPageByName('main', $fields);

$contents = $indexedresult['contents'];

require_once("tpl/main.html"); 
?>