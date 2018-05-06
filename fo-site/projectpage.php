<?php
/* Project page
 * Format: projectpage.php?id=<id>
 * id - id in the table 'staticpages'
 */
require_once("inc/config.php");
$pagename = 'project';
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
    if (($projdata != RESULT_ERROR) && ($projdata != RESULT_EMPTY))
    {
        $contents = $projdata[0]['content'];
    }
}
else
{
    fo_error_msg("Ошибка при переходе на страницу");
    exit;
}

$projectid = $_GET['id'];

echo '<section class="section-main">';
echo '<section class="section-left">';

// взять все дела из works, для которых idprojects равно $_GET["id"]
$keysvalues = [
    'idprojects' => $projectid,
];
$result = getValuesByFieldsOrdered('works', array(), $keysvalues);
if (($result != RESULT_ERROR) && ($result != RESULT_EMPTY))
{
    require_once("works.html");
}

require_once("aside.php");
require_once("tpl/page.html");

require_once("footer.php"); 

?>