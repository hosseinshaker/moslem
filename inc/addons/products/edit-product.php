<?php
$title_page = "ویرایش محصول";
require_once '../../../header.php';

// دریافت آیدی محصول از پارامترهای URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
} else {
    // اگر آیدی محصول موجود نبود، پیام خطا نمایش داده شود یا به صفحه دیگری منتقل شود
    // مثلاً به صفحه لیست محصولات
    header("Location: product_list.php");
    exit();
}

if (isset($_POST['update'])) {
    // دریافت اطلاعات ویرایش شده از فرم
    $product_name_new = $_POST['product_name'];//نام محصول اصلاح شده
    $productqr_new = $_POST['productqr'];//شناسه محصول اصلاح شده
    $minStock_new = $_POST['minStock'];//حداقل موجودی اصلاح شده

    // اپدیت اطلاعات محصول در دیتابیس
    $update_query = "UPDATE products SET product_name = ?, productqr = ?, minStock = ? WHERE id = ?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("siii", $product_name_new, $productqr_new, $minStock_new, $product_id);

    if ($update_stmt->execute() === TRUE) {
        $message_data = "محصول با موفقیت ویرایش شد";
    } else {
        echo "خطا در ویرایش محصول: " . $connection->error;
    }
}

// اطلاعات محصول قبلی را از دیتابیس دریافت کنید
$select_query = "SELECT * FROM products WHERE id = ?";
$select_stmt = $connection->prepare($select_query);
$select_stmt->bind_param("i", $product_id);
$select_stmt->execute();
$result = $select_stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $product_name = $row['product_name'];
    $productqr = $row['productqr'];
    $minStock = $row['minStock'];
} else {
    // اگر محصول با این آیدی وجود نداشت، پیام خطا نمایش داده شود یا به صفحه دیگری منتقل شود
    // مثلاً به صفحه لیست محصولات
    header("Location: product_list.php");
    exit();
}
?>

<div class="main-content">
    <div class="row">
        <?php
        if (!empty($message_data)) :
            ?>
            <div class="col-12">
                <div class="alert alert-success alert-dismissible show fade">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    <?php echo $message_data; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-12 col-md-3 col-lg-3"></div>
        <div class="col-12 col-md-6 col-lg-6">
            <form method="post">
                <div class="card">
                    <div class="card-header">
                        <h4>ویرایش محصول</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>نام محصول</label>
                            <input type="text" class="form-control" name="product_name" value="<?php echo isset($product_name) ? $product_name : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>بارکد محصول(شناسه)</label>
                            <input type="number" class="form-control" name="productqr" value="<?php echo isset($productqr) ? $productqr : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label>حداقل موجودی برای اخطار اتمامی محصول</label>
                            <input type="number" class="form-control" name="minStock" value="<?php echo isset($minStock) ? $minStock : ''; ?>" required>
                        </div>
                        <button class="btn btn-primary" name="update">ویرایش</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-3 col-lg-3"></div>
    </div>
</div>
<?php require_once '../../../footer.php'; ?>