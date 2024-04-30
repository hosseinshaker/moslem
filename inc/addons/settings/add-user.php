<?php
$title_page = "صفحه افزودن کاربر به سامانه";
require_once '../../../header.php';

// بررسی درخواست POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // دریافت داده‌ها از فرم
    $username = $_POST['username'];
    $password = $_POST['password']; // رمز عبور باید به صورت ایمن تولید شود
    $name = $_POST['name'];
    // ترکیب دسترسی‌ها به یک رشته
    $access = isset($_POST['access']) ? implode(',', array_keys($_POST['access'])) : '';
    // چک کردن وجود نام کاربری در دیتابیس
    $query = "SELECT * FROM admintable WHERE username = ?";
    $checkStmt = $connection->prepare($query);
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    if ($result->num_rows > 0) {
        $message_error= "نام کاربری قبلاً ثبت شده است.";
    } else {
        // ایجاد و آماده‌سازی دستور SQL
        $sql = "INSERT INTO admintable (username, password, name, access) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);

        // بایند کردن متغیرها به پارامترهای دستور SQL
        $stmt->bind_param("ssss", $username, $password, $name, $access);

        // اجرای دستور SQL
        if ($stmt->execute()) {
            $message_suc="کاربر جدید با موفقیت اضافه شد.";
        } else {
            echo "خطا: " . $stmt->error;
        }

        // بستن دستور
        $stmt->close();
    }
    // بستن اتصال چک کردن نام کاربری
    $checkStmt->close();

    // بستن اتصال دیتابیس
    $connection->close();
}
?>
<div class="main-content">
<nav class="row">
<?php
if(!empty( $message_suc)):
?>
<nav class="col-12 col-md-12 col-lg-12">
<div class="alert alert-success alert-dismissible show fade">
                      <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                          <span>×</span>
                        </button>
<?php echo$message_suc; ?>
                    </div>
                    </div>
</nav>
<?php
endif;
?>



<?php
if(!empty( $message_error)):
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
                                <h4>فرم  افزودن کاربر به سامانه</h4>
                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <label>نام   کاربری</label>
                                        <input type="text" id="username" name="username" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>پسورد</label>
                                        <input type="password" id="password" name="password"class="form-control"  required>
                                    </div>
                                    <div class="form-group">
                                        <label>نام و نام خانوادگی</label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                    </div>
                                  

                                    <div class="form-group">
    <div class="control-label"> دسترسی های کاربر  </div>
    <?php
    $access_list = array(
        1 => 'ثبت خروج محصول از انبار',
        2 => 'ثبت ورود محصول به انبار',
        3 => 'تعریف محصول جدید',
        4 => 'گزارش محصول های خروجی',
        5 => 'گزارش محصول های ورودی',
        6 => 'لیست محصولات',
        7 => 'گزارش تعداد محصول های خروجی',
        8 => 'گزارش تعداد محصول های ورودی',
        9 => 'تنظیمات',
        10 => 'افزودن کاربر جدید',
        11 => 'لیست کاربران',
        12 => 'پشتیبانی گرفتن از اطلاعات دیتابیس',
        13 => 'موجودی  محصولات'
    );

    foreach ($access_list as $key => $access_item) {
       // echo '<p>' . $access_item . '</p>';
        echo '<label class="custom-switch mt-2">';
        echo '<input type="checkbox" name="access[' . $key . ']" class="custom-switch-input">';
        echo '<span class="custom-switch-indicator"></span>';
        echo '<span class="custom-switch-description">' . $access_item . '</span>';
        echo '</label><br>';
    }
    ?>
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