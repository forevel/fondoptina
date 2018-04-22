<?php

$fields = [
    'title',
    'contents',
];

$indexedresult = getPageByName('footer', $fields);

$footer = $indexedresult['contents'];

require_once("tpl/footer.html"); 
?>