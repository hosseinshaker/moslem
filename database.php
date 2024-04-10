<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moslem";
// اتصال به پایگاه داده
$connection = mysqli_connect($servername, $username , $password , $dbname);
mysqli_query($connection,"SET NAMES 'utf8'");
mysqli_query($connection,"SET CHARACTER SET 'utf8'");
mysqli_query($connection,"SET character_set_connection = 'utf8'");
// بررسی اتصال
if (!$connection) {
    die("اتصال به پایگاه داده با خطا مواجه شد: " . mysqli_connect_error());
}