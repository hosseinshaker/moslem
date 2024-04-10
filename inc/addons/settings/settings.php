<?php
$title_page="صفحه  تنظیمات سامانه";
require_once '../../../header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sitename = $_POST['sitename'];
    $logoPath = "";

    if ($_FILES["logo"]["error"] == 0) {
        $target_dir = "../../../assets/img"; // مسیر ذخیره سازی لوگو
        $target_file = $target_dir . basename($_FILES["logo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // بررسی فرمت فایل و اندازه تصویر
        if (in_array($imageFileType, ["jpg", "png", "jpeg", "gif"]) && getimagesize($_FILES["logo"]["tmp_name"]) !== false) {
            if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                $logoPath = $target_file;
            } else {
                echo "خطا در آپلود فایل.";
                exit;
            }
        } else {
            echo "فرمت فایل یا اندازه تصویر مجاز نیست.";
            exit;
        }
    }

    // اتصال به دیتابیس و به روزرسانی رکورد
    $sql = "UPDATE options SET logo = ? WHERE sitename = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $logoPath, $sitename);

    if ($stmt->execute()) {
        echo "اطلاعات سایت با موفقیت به روز شد.";
    } else {
        echo "خطا در به روزرسانی دیتابیس: " . $stmt->error;
    }

    $stmt->close();
}
?>

<div class="main-content">
<nav class="row">
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="sitename">نام سایت</label>
        <input type="text" id="sitename" name="sitename" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="logo">تصویر سایت</label>
        <input type="file" id="logo" name="logo" class="form-control" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">به روز رسانی</button>
</form>

</nav>
</div>

<?php require_once '../../../footer.php';?>