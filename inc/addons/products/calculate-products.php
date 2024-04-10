<?php
$title_page = "محاسبه نیاز به محصولات اولیه";
require_once '../../../header.php';
$sql = "SELECT * FROM products";
$result = $connection->query($sql);
?>
<!-- دیگر بخش‌های HTML -->
<div class="main-content">
    <nav class="row">
        <div class="col-12 col-md-3 col-lg-1"></div>
        <div class="col-12 col-md-6 col-lg-10">
            <form method="post" action="calculate-table.php">
                <div class="card">
                    <div class="card-header">
                        <h4>محاسبه نیاز به مواد اولیه برای تولید محصول</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>انتخاب محصول تولیدی</label>
                            <select name="product_name" class="form-control select2" required>
                                <option value="">انتخاب*</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . $row['product_name'] . '</option>';
                                    }
                                } else {
                                    echo "<option value=''>نتیجه‌ای یافت نشد</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>تعداد محصول</label>
                            <input type="number" class="form-control" placeholder="مقدار" name="quantity" required>
                        </div>
                        <button class="btn btn-primary" name="calculate">محاسبه نیاز به مواد اولیه</button>
                    </div>
                </div>
            </form>
        </div>
    </nav>
</div>
<?php require_once '../../../footer.php'; ?>