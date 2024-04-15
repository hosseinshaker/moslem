<?php
session_start();

$base_url2 = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
$base_url=$base_url2 . '/moslem';
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: " . $base_url . "/login.php");
    exit;
}
require_once 'database.php';
require_once 'jdf.php';
require_once 'inc/functions.php';
?>
<!DOCTYPE html>
<html lang="Fa">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?php 
    if(isset( $title_page)){
        echo $title_page;
    }
?></title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/app.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/bundles/datatables/datatables.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/bundles/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/bundles/weather-icon/css/weather-icons.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/bundles/weather-icon/css/weather-icons-wind.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/bundles/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/bundles/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/bundles/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/bundles/jquery-selectric/selectric.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='<?php echo $base_url; ?>/logo.ico' />
<style>
tbody>tr>td{
    border: 1px solid #dbdbdb;
}
</style>
</head>
<body class="">
<div class="loader0"></div>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            <div class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
                    <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                            <i data-feather="maximize"></i>
                        </a></li>

                </ul>
            </div>

        </nav>
        <?php
require_once 'menu.php';
?>
