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
                    <p>مدیریت انبار محصول های اولیه</p>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[1]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">تعریف مواد اولیه جدید</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[2]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">لیست مواد های اولیه</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[3]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">خروج مواد اولیه</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[4]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">ورود مواد اولیه</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[5]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">گزارش ورود/خروج مواد اولیه</span>
                    </label>  
                    <p>مدیریت انبار محصول</p>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[6]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">ثبت خروج محصول</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[7]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">ثبت ورود محصول</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[8]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">تعریف محصول جدید</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[9]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">لیست محصول های خروجی</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[10]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">لیست محصول های ورودی</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[11]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">محاسبه مواد اولیه هر محصول</span>
                    </label>  
                    <p>مدیریت کاربران و خیاط ها</p>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[12]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">ثبت کاربر جدید</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[13]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">لیست کاربران</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[14]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">افزودن موجودی انبار کاربر</span>
                    </label>  <br>
             
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[16]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">کاهش موجودی انبار کاربر</span>
                    </label>  <br>
                  
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[18]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">لیست موجودی کاربران</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[19]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">محاسبه حقوق کاربر</span>
                    </label>  <br>

					
					
					
					
					
					
                    <p>مدیریت سامانه</p>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[20]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">تنظیمات</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[21]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">لیست پرسنل سامانه</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[22]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">افزودن پرسنل به سامانه</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[23]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">پشتیبان گیری از اطلاعات</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[25]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">مدیریت رنگ ها</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[15]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description"> افزودن رنگ</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[17]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description"> افزودن طرح</span>
                    </label>  <br>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="access[26]" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">مدیریت طرح ها</span>
                    </label>  <br>
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