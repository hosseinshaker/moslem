<?php
function getColumnValue($connection, $columnName,$tablename) {
    $sql = "SELECT $columnName FROM $tablename";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row[$columnName];
}