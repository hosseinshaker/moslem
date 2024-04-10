<?php
session_start();
require_once 'database.php';

if (!$connection) {
    die("خطا در اتصال به پایگاه داده: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT name, access FROM admintable WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $row["name"];
        $_SESSION["access"] = $row["access"]; // اضافه کردن مقدار access به سشن
        header("Location:index.php");
    } else {
        $error_login = "نام کاربری یا رمز عبور اشتباه است.";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>ورود به سامانه تولیدی شیراز کاور</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <link rel="stylesheet" href="assets/bundles/bootstrap-social/bootstrap-social.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href="logo.ico" />
</head>
<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
              <p class="text-danger"><?php
              if (isset($error_login)){
                  echo $error_login;
              }
              ?></p>
            <div class="card card-primary">

              <div class="card-header">

                <h4>ورود</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="#" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email">نام کاربری</label>
                    <input id="email" type="text" class="form-control" name="username" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                 نام کاربری خود را وارد کنید
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">رمز عبور</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                    رمز عبور خودرا وارد کنید.
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" name="login">
                      ورود
                    </button>
                  </div>
                </form>
                <h4 class="h6">طراحی و برنامه نویسی شده توسط <a href="https://hshaker.ir/">حسین شاکر</a> </h4>
                  <p class="text-info">شماره تماس پشتیبانی : 09174125246 </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>
</html>
