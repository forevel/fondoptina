<?php
/* aside.php: right hand side widget
 * gets last three content blocks from
 * the table 'news' and set them in
 * var $aside
 */
$aside = "";
/* 1. Get current month and year in format Y-m
 * 2. Get all news from news where date > Y-m-01
 * 3. foreach news as new
 * 4.   $aside += "<br>";
 * 5.   $aside +=  "<h2>".new.caption."</h2>";
 * 6.   $aside += "<p>".new.contents."</p>";
 * 7.   $aside += "<p class=\"small\"".new.user." @ ".new.date."</p>";
 */
$curmonth = date('Y-m');
$curmonth .= "-01"; // add first day in month
$keysvalues = array(
    "date" => $curmonth,
);
$fields = array(
    "caption",
    "contents",
    "date",
    "user",
);
$orderby = array(
    "date",
    "DESC",
);
// SELECT * FROM 'news' WHERE 'date'>=$curmonth ORDERBY date DESC;
$result = getValuesByFieldsOrdered("news", $fields, $keysvalues, $orderby, 1);
if ($result == RESULT_ERROR)
    exit;
foreach($result as $r)
{
    $aside .= "<br>";
    $aside .= "<h2>".$r["caption"]."</h2>";
    $aside .= "<p class=\"newsplaintext\">".$r["contents"]."</p>";
//    var_dump($aside);
    $aside .= "<br>";
    $aside .= "<p class=\"smallgray\">".$r["user"]." @ ".$r["date"]."</p>";
}
?>