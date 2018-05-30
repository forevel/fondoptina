<?php
/* Project page
 * Format: projectpage.php?id=<id>
 * id - id in the table 'staticpages'
 */
require_once("inc/config.php");
$contents = '';
if (isset($_GET['id']))
{
    $fields = [
        'descr',
        'content',
        'title',
    ];
    $keysvalues = [
        'id' => $_GET['id'],
        'deleted' => '0',
    ];
    
    $projdata = getValuesByFieldsOrdered('projects', $fields, $keysvalues);
    if (($projdata != RESULT_ERROR) && ($projdata != RESULT_EMPTY))
    {
        $contents = $projdata[0]['content'];
        $projheader = $projdata[0]['descr'];
        $title = $projdata[0]['title'];
    }
}
else
{
    fo_error_msg("Ошибка при переходе на страницу");
    exit;
}

require_once("header.php");

$projectid = $_GET['id'];

echo '<section class="section-main">';
echo '<section class="section-left">';
echo '<h2>'.$projheader.'</h2>';

// взять все дела из works, для которых idprojects равно $_GET["id"]
$keysvalues = [
    'idprojects' => $projectid,
];
$result = getValuesByFieldsOrdered('works', array(), $keysvalues);
if (($result != RESULT_ERROR) && ($result != RESULT_EMPTY))
{
    require_once("tpl/works.html");
}

require_once("aside.php");
require_once("tpl/main.html");
require_once("tpl/aside.html");

require_once("footer.php"); 

?>