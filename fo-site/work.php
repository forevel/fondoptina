<?php
/* Work page
 * Format: work.php?id=<id>
 * id - id in the table 'works'
 */
require_once("inc/config.php");
$pagename = 'work';
$workid = $_GET['id'];
require_once("header.php");
$contents = '';
if (isset($workid))
{
    $fields = [
        'descr',
    ];
    $keysvalues = [
        'id' => $workid,
        'deleted' => '0',
    ];
    
    $workdata = getValuesByFieldsOrdered('works', $fields, $keysvalues);
    if (($workdata != RESULT_ERROR) && ($workdata != RESULT_EMPTY))
    {
        $contents = $workdata[0]['descr'];
    }
}
else
{
    fo_error_msg("Ошибка при переходе на страницу");
    exit;
}

echo '<section class="section-main">';
echo '<section class="section-left">';

echo '<table><tr><td>';
// взять все дела из works, для которых idprojects равно $_GET["id"]
$keysvalues = [
    'id' => $workid,
];
$result = getValuesByFieldsOrdered('works', array(), $keysvalues);
if (($result != RESULT_ERROR) && ($result != RESULT_EMPTY))
{
    require_once("works.html");
}
echo '</td><td>';
$fields = [
    'url',
];

$keysvalues = [
    'idwork' => $workid,
];

$workpics = getValuesByFieldsOrdered('workpics', $fields, $keysvalues);
if (($workpics != RESULT_ERROR) && ($workpics != RESULT_EMPTY))
{
    echo '<table><tr>';
    foreach($workpics as $w)
    {
        echo '<td class="blocktd">';
        echo '<a target="_blank" href='.$w['url'].'><img src='.$w['url'].' /></a>';
        echo '</td>';
    }
    echo '</tr></table>';
}
require_once("aside.php");
require_once("tpl/main.html");
echo '</td></tr></table>';
require_once("tpl/aside.html");
require_once("footer.php"); 

?>