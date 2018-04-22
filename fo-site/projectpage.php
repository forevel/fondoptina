<?php
/* Project page
 * Format: projectpage.php?id=<id>
 * id - id in the table 'staticpages'
 */
require_once("inc/config.php");

require_once("header.php");
$contents = '';
if (isset($_GET['id']))
{
    $fields = [
        'content',
    ];
    $keysvalues = [
        'id' => $_GET['id'],
        'deleted' => '0',
    ];
    
    $projdata = getValuesByFieldsOrdered('content', $fields, $keysvalues);
    if ($projdata != RESULT_ERROR)
    {
        if ($projdata != RESULT_EMPTY)
        {
            $contents = $projdata[0]['content'];
        }
    }
}
else
    fo_error_msg("Ошибка при переходе на страницу");

require_once("aside.php");

require_once("tpl/page.html");

require_once("footer.php"); 

?>