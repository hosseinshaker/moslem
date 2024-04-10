<?php
$title_page = "صفحه افزودن طرح به سامانه";
require_once '../../../header.php';

// بررسی درخواست POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // دریافت نام طرح از فرم
    $materialName = $_POST['material_name'];

    // چک کردن وجود نام طرح در دیتابیس
    $query = "SELECT * FROM materials WHERE material_name = ?";
    $checkStmt = $connection->prepare($query);
    $checkStmt->bind_param("s", $materialName);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    if ($result->num_rows > 0) {
        $message_error = "نام طرح قبلاً ثبت شده است.";
    } else {
        // ایجاد و آماده‌سازی دستور SQL
        $sql = "INSERT INTO materials (material_name) VALUES (?)";
        $stmt = $connection->prepare($sql);

        // بایند کردن متغیرها به پارامترهای دستور SQL
        $stmt->bind_param("s", $materialName);

        // اجرای دستور SQL
        if ($stmt->execute()) {
            $message_suc = "طرح جدید با موفقیت اضافه شد.";
        } else {
            echo "خطا: " . $stmt->error;
        }

        // بستن دستور
        $stmt->close();
    }
    // بستن اتصال چک کردن نام طرح
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
                                <h4>فرم  افزودن طرح به سامانه</h4>
                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <label>نام طرح</label>
                                        <input type="text" id="material_name" name="material_name" class="form-control" required>
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
