<?php
/* Contacts page
 * A page with a map on it
 */
require_once("inc/config.php");
$pagename = 'contacts';
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
echo '<section class="section-main">';
echo '<section class="section-left">';
require_once("aside.php");

require_once("tpl/main.html");
require_once("tpl/aside.html");


require_once("footer.php"); 

?>