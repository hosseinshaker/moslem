<?php
$title_page = "ویرایش محصول اولیه";
require_once '../../../header.php';

$id = $_GET['id'] ?? null;

// بارگذاری اطلاعات محصول برای ویرایش
if ($id) {
    $sql = "SELECT * FROM primaryproduct WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}
if (isset($_POST['update'])) {
    // پارامترهای محصول اولیه
    $product_name = $_POST['product_name'];
    $productType = $_POST['productType'];
    $entryDate = $_POST['entryDate'];
    $minStock = $_POST['minStock'];
    $productPattern = $_POST['productPattern'] ?? '';
    $productColor = $_POST['productColor'] ?? '';
    // دستور UPDATE
    $sql = "UPDATE primaryproduct SET product_name=?,  productType=?, entryDate=?, minStock=?, productPattern=?, productColor=? WHERE id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssssi", $product_name, $productType, $entryDate, $minStock, $productPattern, $productColor, $id);

    if ($stmt->execute() === TRUE) {
        $message_data = "True";
    } else {
        echo "خطا در به‌روزرسانی محصول اولیه: " . $connection->error;
    }
    $connection->close();
}
?>

<div class="main-content">
    <nav class="row">
        <?php
        if (!empty($message_data) && $message_data = "True") :
        ?>
            <nav class="col-12 col-md-12 col-lg-12">
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        محصول اولیه با موفقیت به‌روزرسانی شد
                    </div>
                </div>
            </nav>
        <?php
        endif;
        ?>
        <div class="col-12 col-md-3 col-lg-3"></div>
        <div class="col-12 col-md-6 col-lg-6">
            <form method="post">
                <div class="card">
                    <div class="card-header">
                        <h4>ویرایش محصول اولیه</h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <div class="form-group">
                            <label>نام محصول اولیه</label>
                            <input type="text" class="form-control" name="product_name" value="<?php echo $product['product_name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>واحد</label>
                            <select class="form-control" required name="productType">
                                <option value="انتخاب نشده" selected>انتخاب کنید</option>
                                <option value="عدد" <?php if ($product['productType'] == 'عدد') echo 'selected'; ?>>عدد</option>
                                <option value="گرم" <?php if ($product['productType'] == 'گرم') echo 'selected'; ?>>گرم</option>
                                <option value="کیلوگرم" <?php if ($product['productType'] == 'کیلوگرم') echo 'selected'; ?>>کیلوگرم</option>
                                <option value="سانتی متر" <?php if ($product['productType'] == 'سانتی متر') echo 'selected'; ?>>سانتی متر</option>
                                <option value="متر" <?php if ($product['productType'] == 'متر') echo 'selected'; ?>>متر</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>طرح</label>
                            <input type="text" class="form-control" name="productPattern" value="<?php echo $product['productPattern']; ?>">
                        </div>
                        <div class="form-group">
                            <label>رنگ</label>
                            <input type="text" class="form-control" name="productColor" value="<?php echo $product['productColor']; ?>">
                        </div>
                        <div class="form-group">
                            <label>تاریخ ورود:</label>
                            <input id="datepicker-check-in" name="entryDate" class="form-control" value="<?php echo $product['entryDate']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>حداقل موجودی برای اخطار اتمامی محصول اولیه</label>
                            <input type="number" class="form-control" name="minStock" value="<?php echo $product['minStock']; ?>" required>
                        </div>
                        <button class="btn btn-primary" name="update">به‌روزرسانی</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-3 col-lg-3"></div>
    </nav>
</div>
<?php require_once '../../../footer.php'; ?>