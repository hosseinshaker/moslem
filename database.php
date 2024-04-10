<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moslem";
// اتصال به پایگاه داده
$connection = mysqli_connect($servername, $username , $password , $dbname);

// بررسی اتصال
if (!$connection) {
    die("اتصال به پایگاه داده با خطا مواجه شد: " . mysqli_connect_error());
}