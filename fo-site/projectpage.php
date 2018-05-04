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
{
    fo_error_msg("Ошибка при переходе на страницу");
    exit;
}

$projectid = $_GET['id'];
require_once("aside.php");

echo '<section class="section-main">';
echo '<section class="section-left">';

// взять все дела из works, для которых idprojects равно $_GET["id"]
// для каждого дела вставить картинку из .img, добавить надпись из .name
// и нарисовать два прогрессбара: один с деньгами с процентом из .moneygot/.moneyneed
// и второй - с прогрессом дела из .workprogress

require_once("tpl/page.html");

require_once("footer.php"); 

?>