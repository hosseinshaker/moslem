<?php
$title_page = "صفحه ویرایش کاربر در سامانه";
require_once '../../../header.php';

if(isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $access = isset($_POST['access']) ? implode(',', $_POST['access']) : '';

    $update_query = "UPDATE admintable SET username=?, name=?, access=? WHERE id=?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("sssi", $username, $name, $access, $user_id);
    
    if ($update_stmt->execute()) {
        echo "<p>اطلاعات کاربر با موفقیت بروزرسانی شد.</p>";
    } else {
        echo "<p>خطا در بروزرسانی اطلاعات کاربر.</p>";
    }

    $update_stmt->close();
}

// ابتدا بررسی می‌کنیم که آیا شناسه کاربر ارسال شده است یا خیر
if(isset($_GET['id'])) {
    // دریافت شناسه کاربر از روش GET
    $user_id = $_GET['id'];
    
    // استعلام برای خواندن اطلاعات کاربر از دیتابیس
    $query = "SELECT * FROM admintable WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // اگر کاربر با این شناسه وجود داشته باشد، اطلاعات را نمایش می‌دهیم
        $row = $result->fetch_assoc();
?>
        <!-- نمایش فرم برای بروزرسانی -->
        <div class="main-content">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>فرم ویرایش کاربر در سامانه</h4>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                <div class="form-group">
                                    <label>نام کاربری</label>
                                    <input type="text" id="username" name="username" class="form-control" value="<?php echo isset($_POST['username']) ? $_POST['username'] : $row['username']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>نام و نام خانوادگی</label>
                                    <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $row['name']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>دسترسی‌ها</label>
                                    <!-- در اینجا دسترسی‌های کاربر از دیتابیس خوانده شده و نمایش داده می‌شوند -->
                                    <?php
                                    $access_array = explode(',', $row['access']);
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
                                        $checked = in_array($key, $access_array) ? 'checked' : '';
                                        echo '<label class="custom-switch mt-2">';
                                        echo '<input type="checkbox" name="access[' . $key . ']" class="custom-switch-input" value="' . $key . '" ' . $checked . '>';
                                        echo '<span class="custom-switch-indicator"></span>';
                                        echo '<span class="custom-switch-description">' . $access_item . '</span>';
                                        echo '</label><br>';
                                    }
                                    ?>
                                </div>
                                <button type="submit" class="btn btn-primary" name="update">بروزرسانی</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        echo "<p>کاربر با این شناسه وجود ندارد.</p>";
    }
} else {
    echo "<p>شناسه کاربر مشخص نشده است.</p>";
}
?>

<?php require_once '../../../footer.php'; ?>
