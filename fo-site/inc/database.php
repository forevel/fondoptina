<?php

$link = null;

function dbConnect()
{
    global $link;
    $link = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    if (!$link) 
    {
        fo_error_msg("Невозможно установить соединение с MySQL\n".mysqli_connect_error());
        exit;
    }
    mysqli_query($link, "SET NAMES UTF8");
}

// http://programmer-weekdays.ru/archives/301

function newRecord($table, $keysvalues)
{
    global $link;
    if (!$link)
        dbConnect();
    $query = "SELECT `id` FROM `$table` ORDER BY `id` DESC LIMIT 1;";
//    fo_error_msg($query);
    $result = mysqli_query($link, $query);
    if (!$result)
    {
        fo_error_msg("Acquiring key id failed");
        return RESULT_ERROR;
    }
    $idres = mysqli_fetch_assoc($result);
    $id = $idres['id'];
//    var_dump($idres);
    if ($id == "")
        $id = "1"; // если таблица пустая, первым id будет 1
    else
        $id++; // converting to int and set it to next free index
    $query = "INSERT INTO `$table` (`id`) VALUES (\"$id\");"; // inserting
//    fo_error_msg ($query);
    $result = mysqli_query($link, $query);
    if (!$result)
    {
        fo_error_msg("Inserting id $id into table $table failed");
        return RESULT_ERROR;
    }
    if (updateTableById($table, $keysvalues, $id) != RESULT_GOOD)
        return RESULT_ERROR;
    return $id;
}

function updateTableById($table, $keysvalues, $id)
{
    global $link;
    if (!$link)
        dbConnect();
    $query = "UPDATE `$table` SET ";
    foreach($keysvalues as $key => $value)
    {
        $key = mysqli_real_escape_string($link, $key);
        $value = mysqli_real_escape_string($link, $value);
        $query .= "`$key` = \"$value\",";
    }
    $query = substr($query, 0, -1); // deleting the last character from the query
    $query .= " WHERE `id`=$id;";
//    fo_error_msg($query);
    $result=mysqli_query($link, $query);
    if (!$result)
    {
        fo_error_msg(sprintf("Inserting into $table failed. Error: %s", mysqli_error($link)));
        return RESULT_ERROR;
    }
    return RESULT_GOOD;
}

function deleteFromTableById($table, $id)
{
    return deleteFromTable($table, 'id', $id);
}

function deleteFromTable($table, $field, $value, $real=0)
{
    global $link;
    $field = mysqli_real_escape_string($link, $field);
    $value = mysqli_real_escape_string($link, $value);
    if ($real)
    {
        $query = "DELETE FROM `$table` WHERE `$field`=\"$value\";";
    }
    else
    {
        $query = "UPDATE `$table` SET `deleted`='1' WHERE `$field`=\"$value\";";
    }
//    fo_error_msg ($query);
    $result=mysqli_query($link, $query);
    if (!$result)
    {
        fo_error_msg(sprintf("Deleting from $table failed. Error: %s", mysqli_error($link)));
        return RESULT_ERROR;
    }
    return RESULT_GOOD;
}

function getFullTable($table)
{
    return getValuesByFieldsOrdered($table);
}

/* selects $fields from $table by $keysvalues
 * ordered by $orderby[0] in $orderby[1] order (ASC|DESC)
 * primary function to get data from database
 * if $fields is empty gets all values from db
 * if $keysvalues is empty sends unconditional query
 * $equals <0 => condition "<="; =0 => "="; >0 => ">="
 */

function getValuesByFieldsOrdered($table, $fields=array(), $keysvalues=array(), $orderby=array(), $equals=0)
{
    global $link;
    if (!$link)
        dbConnect();
    if ($equals == 0)
        $comparesign = "=";
    else if ($equals < 0)
        $comparesign = "<=";
    else
        $comparesign = ">=";
    $query="SELECT ";
    if (!empty($fields))
    {
        foreach($fields as $f)
        {
            $f = mysqli_real_escape_string($link, $f);
            $query .= "`$f`,";
        }
        $query = substr($query, 0, -1); // deleting last char from $query
    }
    else // no fields
        $query .= "*"; // selects all if there's no any fields
    $query .= " FROM `$table`";
    $query .= " WHERE ";
    if (!empty($keysvalues)) // conditions exists
    {
        foreach($keysvalues as $key => $value)
        {
            $key = mysqli_real_escape_string($link, $key);
            $value = mysqli_real_escape_string($link, $value);
            $query .= "`$key`".$comparesign."\"$value\" AND ";
        }
        $query = substr($query, 0, -4); // deletes last "AND "
    }
    else
    {
        $query .= "`deleted`='0' ";
    }
    if (!empty($orderby))
    {
        $query .= " ORDER BY `$orderby[0]` $orderby[1];";
    }
    $query .= ";";
//    fo_error_msg ($query);
    $result=mysqli_query($link, $query);
    if (!$result)
    {
        fo_error_msg("Checking login info failed. Error: ".mysqli_error($link)." => ".$query);
        return RESULT_ERROR;
    }

    $n = mysqli_num_rows($result);
    if ($n == 0) // empty result
        return RESULT_EMPTY;

    $retvalue = array();
    
    for ($i=0; $i<$n; $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $retvalue[] = $row;
    }
    return $retvalue;
}

function dbDisconnect()
{
    global $link;
    if (!$link)
        return;
    mysqli_close($link);
}

?>