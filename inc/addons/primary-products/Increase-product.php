<?php
$title_page = "افزایش موجودی محصولات اولیه";
require_once '../../../header.php';

// دریافت لیست محصولات اولیه
$sql = "SELECT id, product_name, productPattern, productColor, productCount FROM primaryproduct";
$result = $connection->query($sql);

// افزایش موجودی
if (isset($_POST['increase_stock'])) {
    $productId = $_POST['product_id'];
    $increaseAmount = $_POST['increase_amount'];
    $entryDate = $_POST['entryDate'];

    if ($increaseAmount > 0) {
        // بازیابی اطلاعات محصول برای مقایسه
        $sql_check_stock = "SELECT productCount, productPattern, productColor, product_name FROM primaryproduct WHERE id = ?";
        $stmt_check_stock = $connection->prepare($sql_check_stock);
        $stmt_check_stock->bind_param("i", $productId);
        $stmt_check_stock->execute();
        $result_check_stock = $stmt_check_stock->get_result()->fetch_assoc();

        if ($result_check_stock) {
            // به‌روزرسانی موجودی در پایگاه داده
            $newStock = $result_check_stock['productCount'] + $increaseAmount;

            $sql_update_stock = "UPDATE primaryproduct SET productCount = ? WHERE id = ?";
            $stmt_update_stock = $connection->prepare($sql_update_stock);
            $stmt_update_stock->bind_param("ii", $newStock, $productId);
            $stmt_update_stock->execute();

            // اطلاعات برای ثبت در جدول PrimaryProductReport
            $productName = $result_check_stock['product_name'];
            $productPattern = $result_check_stock['productPattern'];
            $productColor = $result_check_stock['productColor'];
            $byUser = $_SESSION['username'];
            $status = "increase";

            // ثبت در جدول PrimaryProductReport
            $sql_insert_report = "INSERT INTO PrimaryProductReport (productName, productPattern, productColor, date, value, user, status, stock) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert_report = $connection->prepare($sql_insert_report);
            $stmt_insert_report->bind_param("sssssssi", $productName, $productPattern, $productColor, $entryDate, $increaseAmount, $byUser, $status, $newStock);
            $stmt_insert_report->execute();

            $message = "موجودی محصول افزایش یافت و گزارش ثبت شد.";
        } else {
            $error_message = "محصول یافت نشد.";
        }
    } else {
        $error_message = "لطفا یک مقدار مثبت وارد کنید.";
    }
}
$connection->close();
?>

<div class="main-content">
    <nav class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <?php if (isset($message)): ?>
                <div class="alert alert-success">
                    <?php echo $message; ?>
                </div>
            <?php elseif (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <!-- فرم افزایش موجودی -->
            <form method="post">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>انتخاب محصول</label>
                            <select name="product_id" class="form-control   select2">
                                <?php
                                while ($row = $result->fetch_assoc()):
                                    $productName = $row['product_name'];
                                    $productPattern = $row['productPattern'];
                                    $productColor = $row['productColor'];

                                    // تولید متن برای نمایش در Select
                                    $displayText = $productName;
                                    if (!empty($productPattern)) {
                                        $displayText .= " - طرح: " . $productPattern;
                                    }
                                    if (!empty($productColor)) {
                                        $displayText .= " - رنگ: " . $productColor;
                                    }
                                ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $displayText; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>تاریخ :</label>
                            <input  id="datepicker-check-in" name="entryDate" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>تعداد برای افزایش</label>
                            <input type="number" name="increase_amount" class="form-control" required>
                        </div>
                        <button type="submit" name="increase_stock" class="btn btn-primary">افزایش موجودی</button>
                    </div>
                </div>
            </form>
        </div>
    </nav>
</div>

<?php require_once '../../../footer.php'; ?>
