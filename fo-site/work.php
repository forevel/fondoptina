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

// взять все дела из works, для которых idprojects равно $_GET["id"]
$keysvalues = [
    'id' => $workid,
];
$result = getValuesByFieldsOrdered('works', array(), $keysvalues);
if (($result != RESULT_ERROR) && ($result != RESULT_EMPTY))
{
    require_once(__DIR__ . "/tpl/workhorizontal.html");
}
$fields = [
    'url',
];

$keysvalues = [
    'idwork' => $workid,
];

echo '<div class="container640x480">';
$workpics = getValuesByFieldsOrdered('workpic', $fields, $keysvalues);
if (($workpics != RESULT_ERROR) && ($workpics != RESULT_EMPTY))
{
    $counter = 0;
    echo '<div id="slider"><ul id="sliderul">';
    foreach($workpics as $w)
    {
        include (__DIR__ . "/tpl/sliderpic.html");
        $counter++;
    }
    echo '</ul></div>';
    echo '</div>';
    echo '<script type="text/javascript">InitSlides()</script>';
}
require_once("aside.php");
require_once("tpl/main.html");
require_once("tpl/aside.html");
require_once("footer.php"); 

?>