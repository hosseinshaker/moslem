<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database_name = "samane";
// Get connection object and set the charset
$conn = mysqli_connect($host, $username, $password, $database_name);
$conn->set_charset("utf8");
// Get All Table Names From the Database
$tables = array();
$sql = "SHOW TABLES";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}
$sqlScript = "";
foreach ($tables as $table) {
// Prepare SQLscript for creating table structure
    $query = "SHOW CREATE TABLE $table";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $sqlScript .= "\n\n" . $row[1] . ";\n\n";
    $query = "SELECT * FROM $table";
    $result = mysqli_query($conn, $query);
    $columnCount = mysqli_num_fields($result);
// Prepare SQLscript for dumping data for each table
    for ($i = 0; $i < $columnCount; $i ++) {
        while ($row = mysqli_fetch_row($result)) {
            $sqlScript .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < $columnCount; $j ++) {
                $row[$j] = $row[$j];
                if (isset($row[$j])) {
                    $sqlScript .= '"' . $row[$j] . '"';
                } else {
                    $sqlScript .= '""';
                }
                if ($j < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
    }

    $sqlScript .= "\n";
}

if (!empty($sqlScript)) {
    // Save the SQL script to a backup file
    require_once 'jdf.php';
    $backup_directory = 'backup/';
    if (!is_dir($backup_directory)) {
        mkdir($backup_directory, 0777, true);
    }
    $backup_file_name = $backup_directory . $database_name . '_backup_' . jdate('Y_m_d_H_i_s', '', '', '', 'en') . '.sql';
    $fileHandler = fopen($backup_file_name, 'w+');
    $number_of_lines = fwrite($fileHandler, $sqlScript);
    fclose($fileHandler);


    $title_page="بکاپ";
    require_once 'header.php';
    echo '<div class="main-content">

    <section class="section">
    <nav class="row">
      <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-body">
    ';

    echo 'پشتیبان گیری با موفقیت انجام شد.';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<a href="index.php" class="btn btn-primary mr-1">ورود به صفحه اصلی</a>';
    echo '</div></div></div></nav></section></div>';
    require_once 'footer.php';
}