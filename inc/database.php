<?php

// require_once "config.php";
$link = null;

function db_connect()
{
    global $link;
    $link = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    if (!$link) 
    {
        error_msg("Невозможно установить соединение с MySQL\n".mysqli_connect_error());
        exit;
    }
}

// http://programmer-weekdays.ru/archives/301

function newRecord($table, $fieldsvalues)
{
    global $link;
    $query = "SELECT `id` FROM $table ORDERBY `id` DESC LIMIT 1;";
    $id = mysqli_query($link, $query);
    if (!$id)
    {
        printf("Acquiring key id failed");
        return RESULT_ERROR;
    }
    if ($id == "")
        $id = "1"; // если таблица пустая, первым id будет 1
    else
        $id++; // converting to int and set it to next free index
    $query = "INSERT INTO `$table` (`id`) VALUES (`$id`);"; // inserting
    $result = mysqli_query($link, $query);
    if (!$result)
    {
        error_msg("Inserting id $id into table $table failed");
        return RESULT_ERROR;
    }
    return update_table_with_values($table, $keysvalues, $id);
}

function update_table_with_values($table, $keysvalues, $id)
{
    $query = "UPDATE `$table` SET ";
    foreach($fieldsvalues as $key => $value)
    {
        $key = mysqli_real_escape_string($link, $key);
        $value = mysqli_real_escape_string($link, $value);
        $query .= "`$key` = `$value`,";
    }
    $query = substr($query, 0, -1); // deleting the last character from the query
    $query .= " WHERE `id`=$id;";
    $result=mysqli_query($link, $query);
    if (!$result)
    {
        error_msg(sprintf("Inserting into $table failed. Error: %s", mysqli_error($link)));
        return RESULT_ERROR;
    }
    return RESULT_GOOD;
}

function delete_from_db($table, $id)
{
    $query = "DELETE FROM `$table` WHERE `id`=$id;";
    $result=mysqli_query($link, $query);
    if (!$result)
    {
        error_msg(sprintf("Deleting from $table failed. Error: %s", mysqli_error($link)));
        return RESULT_ERROR;
    }
    return RESULT_GOOD;
}

function get_table_from_db($table)
{
    global $link;
    
    return get_table_from_db_with_conditions($table);
/*    $query = "SELECT * FROM `$table`";
    $result = mysqli_query($link, $query);
    
    if (!$result)
    {
        echo "<br><script type=\"text/javascript\">alert(\"Selecting projects failed\");</script>";
        return false;
    }    
    $n = mysqli_num_rows($result);
    $retvalue = array();
    
    for ($i=0; $i<$n; $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $retvalue[] = $row;
    }
    return $retvalue; */
}

/* selects $fields from $table by $keysvalues
 * primary function to get data from database
 * if $fields is empty gets all values from db
 * if $keysvalues is empty sends unconditional query
 */

function get_table_from_db_with_conditions($table, $fields=array(), $keysvalues=array())
{
    global $link;
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
    if (!empty($keysvalues)) // conditions exists
    {
        $query .= " WHERE ";
        foreach($keysvalues as $key => $value)
        {
            $key = mysqli_real_escape_string($link, $key);
            $value = mysqli_real_escape_string($link, $value);
            $query .= "`$key`=\"$value\" AND ";
        }
        $query = substr($query, 0, -4); // deletes last "AND "
    }
    $query .= ";";
//    echo $query;
    $result=mysqli_query($link, $query);
    if (!$result)
    {
        error_msg("Checking login info failed. Error: ".mysqli_error($link)." => ".$query);
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

function db_disconnect()
{
    global $link;
    mysqli_close($link);
}

?>