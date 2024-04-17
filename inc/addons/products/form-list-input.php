<?php
$title_page = "فرم گزارش محصولات ورودی";
require_once '../../../header.php';

// دستور SELECT برای دریافت لیست محصولات
$sql = "SELECT DISTINCT product_Name FROM products";
$result = $connection->query($sql);
?>
<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>گزارش انبار اولیه</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="list-input-product.php">
                            <nav class="form-row">
                                <nav class="form-group col-md-6">
                                    <div class="form-group">
                                        <label>نام محصول اولیه</label>
                                        <select name="productName" class="form-control select2">
                                            <option value="">همه</option>
                                            <?php
                                            // حلقه برای نمایش گزینه‌ها
                                            while ($row = $result->fetch_assoc()) :
                                                $productName = $row['product_Name'];
                                            ?>
                                                <option value="<?php echo $productName; ?>"><?php echo $productName ; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </nav>
                                <nav class="form-group col-md-6">
                                    <div class="form-group">
                                        <label>شناسه ورود</label>
                                          <input type="number" class="form-control" name="entry_id">
                                        </select>
                                    </div>
                                </nav>
                                <nav class="form-group col-md-6">
                                    <div class="form-group">
                                        <label>از تاریخ</label>
                                        <input id="datepicker-check-in" class="form-control" name="date_in">
                                    </div>
                                </nav>
                                <nav class="form-group col-md-6">
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
