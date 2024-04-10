<?php
$title_page = "ویرایش کاربر";
require_once '../../../header.php';

// اگر فرم ویرایش ارسال شده باشد
if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $new_username = $_POST['new_username'];

    // به‌روزرسانی اطلاعات کاربر
    $update_query = "UPDATE users SET username = '$new_username' WHERE id = $user_id";
    mysqli_query($connection, $update_query);

    $success_message = '<div class="alert alert-success alert-dismissible show fade">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>×</span>
                            </button>
                            اطلاعات کاربر با موفقیت به‌روزرسانی شد.
                          </div>
                        </div>';
}

// اگر شناسه کاربر از URL درخواست شده باشد
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // دریافت اطلاعات کاربر از دیتابیس
    $user_query = "SELECT * FROM users WHERE id = $user_id";
    $user_result = mysqli_query($connection, $user_query);

    // اطمینان از وجود اطلاعات
    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_data = mysqli_fetch_assoc($user_result);
    } else {
        // شناسه کاربر نامعتبر است، می‌توانید به یک صفحه خطا یا لیست کاربران هدایت کنید.
        header("Location: error-page.php");
        exit();
    }
}
?>

<div class="main-content">
    <section class="section">
        <?php
        if (isset($success_message)) {
            echo $success_message;
        }
        ?>

        <div class="row">
            <div class="col-12 col-md-2"></div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>ویرایش کاربر</h4>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <input type="hidden" name="user_id" value="<?php echo isset($user_data['id']) ? $user_data['id'] : ''; ?>">

                            <div class="form-group">
                                <label>نام کاربر:</label>
                                <input type="text" name="new_username" class="form-control" value="<?php echo isset($user_data['username']) ? $user_data['username'] : ''; ?>" required>
                            </div>

                            <div class="card-footer text-right">
                                <input type="submit" class="btn btn-primary mr-1" name="update" value="ذخیره تغییرات">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-2"></div>
        </div>
    </section>
</div>

<?php require_once '../../../footer.php'; ?>
