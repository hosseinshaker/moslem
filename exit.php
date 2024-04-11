<?php
session_start(); // استارت سکشن فعلی

// بررسی وجود ورود
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // حذف تمامی متغیرهای سکشن
    $_SESSION = array();


    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // نهایی کردن سکشن
    session_destroy();

    // منتقل کردن کاربر به صفحه خروج
    header("Location:login.php"); // جایگزین کنید
    exit;
}
?>