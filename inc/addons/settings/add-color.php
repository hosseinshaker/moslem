<?php
$title_page = "صفحه افزودن رنگ به سامانه";
require_once '../../../header.php';

// بررسی درخواست POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // دریافت نام رنگ از فرم
    $colorName = $_POST['color_name'];

    // چک کردن وجود نام رنگ در دیتابیس
    $query = "SELECT * FROM colors WHERE colorname = ?";
    $checkStmt = $connection->prepare($query);
    $checkStmt->bind_param("s", $colorName);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    if ($result->num_rows > 0) {
        $message_error = "نام رنگ قبلاً ثبت شده است.";
    } else {
        // ایجاد و آماده‌سازی دستور SQL
        $sql = "INSERT INTO colors (colorname) VALUES (?)";
        $stmt = $connection->prepare($sql);

        // بایند کردن متغیرها به پارامترهای دستور SQL
        $stmt->bind_param("s", $colorName);

        // اجرای دستور SQL
        if ($stmt->execute()) {
            $message_suc = "رنگ جدید با موفقیت اضافه شد.";
        } else {
            echo "خطا: " . $stmt->error;
        }

        // بستن دستور
        $stmt->close();
    }
    // بستن اتصال چک کردن نام رنگ
    $checkStmt->close();

    // بستن اتصال دیتابیس
    $connection->close();
}
?>
<div class="main-content">
<nav class="row">
<?php
if (!empty($message_suc)):
?>
<nav class="col-12 col-md-12 col-lg-12">
<div class="alert alert-success alert-dismissible show fade">
                      <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                          <span>×</span>
                        </button>
<?php echo $message_suc; ?>
                    </div>
                    </div>
</nav>
<?php
endif;
?>



<?php
if (!empty($message_error)):
?>
<nav class="col-12 col-md-12 col-lg-12">
<div class="alert alert-danger alert-dismissible show fade">
                      <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                          <span>×</span>
                        </button>
<?php echo $message_error; ?>
                    </div>
                    </div>
</nav>
<?php
endif;
?>



<div class="col-12 col-md-3 col-lg-3"></div>
<div class="col-12 col-md-6 col-lg-6">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="card">
                                <div class="card-header">
                                <h4>فرم  افزودن رنگ به سامانه</h4>
                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <label>نام رنگ</label>
                                        <input type="text" id="color_name" name="color_name" class="form-control" required>
                                    </div>
                                </div>

                                    <button class="btn btn-primary" name="insert">افزودن</button>
                                </div>
                            </div>
             </form>
</div>
<div class="col-12 col-md-3 col-lg-3"></div>
</nav>
</div>
</div>
<?php require_once '../../../footer.php';?>