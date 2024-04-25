<?php
$title_page = "فرم گزارش محصولات خروجی";
require_once '../../../header.php';

// دستور SELECT برای دریافت لیست محصولات
$products_sql = "SELECT * FROM products";
$products_result = $connection->query($products_sql);
?>
<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>فرم جستجو میان فاکتور های خروجی</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="report-output-product.php">
                            <nav class="form-row">
                            <div class="form-group col-md-4">
                             
                             <label>نام محصول و یا بارکد</label>
                             <select  name="productName[]" class="form-control select2">
                                 <?php
                                 if ($products_result->num_rows > 0) {
                                     while ($products_row = $products_result->fetch_assoc()) {
                                         echo '<option value="' . $products_row['productqr'] . '">' . $products_row['product_name'] .' کد: '.$products_row['productqr'] . '</option>';
                                     }
                                 } else {
                                     echo "<option value=''>نتیجه‌ای یافت نشد</option>";
                                 }
                                 ?>
                             </select>
                                 </div>
                                <nav class="form-group col-md-4">
                                    <div class="form-group">
                                        <label>از تاریخ</label>
                                        <input id="datepicker-check-in" class="form-control" name="date_in">
                                    </div>
                                </nav>
                                <nav class="form-group col-md-4">
                                    <div class="form-group">
                                        <label>تا تاریخ</label>
                                        <input id="datepicker-Depart" class="form-control" name="date_out">
                                    </div>
                                </nav>
                                <div class="card-footer text-right">
                                    <input type="submit" class="btn btn-primary mr-1" name="send" value="جستجو...">
                                </div>
                            </nav>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once '../../../footer.php'; ?>
