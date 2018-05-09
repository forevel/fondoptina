<?php
/* Contribute page
 * Format: contribute.php
 * id - id in the table 'works'
 */
require_once("inc/config.php");
$pagename = 'contribute';
require_once("header.php");
$contents = '';
if (isset($id))
{
    $fields = [
        'name',
    ];
    $keysvalues = [
        'id' => $id,
        'deleted' => '0',
    ];
    
    $contribdata = getValuesByFieldsOrdered('works', $fields, $keysvalues);
    if (($contribdata != RESULT_ERROR) && ($contribdata != RESULT_EMPTY))
    {
        $contents = $contribdata[0]['name'];
    }
}
else
{
    fo_error_msg("Ошибка при переходе на страницу");
    exit;
}

echo '<section class="section-main">';
echo '<section class="section-left">';

require_once("aside.php");
require_once("tpl/contribute.html");

require_once("footer.php"); 

?>