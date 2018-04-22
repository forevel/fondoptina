<?php
/* Contacts page
 * A page with a map on it
 */
require_once("inc/config.php");

require_once("header.php");

$fields = [
    'contents',
];
$keysvalues = [
    'pagename' => 'contacts',
    'deleted' => '0',
];

$projdata = getValuesByFieldsOrdered('staticpages', $fields, $keysvalues);
if ($projdata != RESULT_ERROR)
{
    if ($projdata != RESULT_EMPTY)
    {
        $contents = $projdata[0]['contents'];
    }
}

require_once("aside.php");

require_once("tpl/page.html");

require_once("footer.php"); 

?>