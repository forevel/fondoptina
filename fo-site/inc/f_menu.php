<?php
require_once("config.php");

function getMenuitemByIdalias($id)
{
    $fields = [
        'id',
        'name',
        'url',
    ];
    $keysvalues = [
        'idalias' => $id,
    ];
    $orderby = [
        'order',
        'ASC',
    ];

    $menu = getValuesByFieldsOrdered('menu', $fields, $keysvalues, $orderby);
    if ($menu == RESULT_ERROR)
    {
        fo_error_msg("Ошибка получения данных по меню");
        exit;
    }
    return $menu;
}
?>