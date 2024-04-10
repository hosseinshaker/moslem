<?php
$title_page = "فرم مشاهده محصولات ورودی";
require_once '../../../header.php';
// نمایش محصولات
$sql_products = "SELECT * FROM products";
$result_products = $connection->query($sql_products);
// نمایش کاربران
$sql_users = "SELECT * FROM users";
$result_user = $connection->query($sql_users);
?>
<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>فرم مشاهده محصولات ورودی</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="inputlist.php">
                            <nav class="form-row">
                                <nav class="form-group col-md-6">
                                    <div class="section-title">نام خیاط یا کاربر</div>
                                    <div class="form-group">
                                        <label>نام خیاط یا کاربر را وارد کنید</label>
                                        <select name="username" class="form-control select2">
                                            <option value="">انتخاب کنید</option>
                                            <?php
                                            if ($result_user->num_rows > 0) {
                                                while($row = $result_user->fetch_assoc()) {
                                                    echo '<option value="'.$row['username'].'">'.$row['username'].'</option>';
                                                }
                                            } else {
                                                echo "<option>نتیجه‌ای یافت نشد</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </nav>
                                <nav class="form-group col-md-6">
                                    <div class="section-title">نام محصول تولید شده</div>
                                    <div class="form-group">
                                        <label>نام محصول تولید شده</label>
                                        <select name="productName" class="form-control select2">
                                            <option value="">انتخاب کنید</option>
                                            <?php
                                            if ($result_products->num_rows > 0) {
                                                while($row = $result_products->fetch_assoc()) {
                                                    echo '<option value="'.$row['product_name'].'">'.$row['product_name'].'</option>';
                                                }
                                            } else {
                                                echo "<option>نتیجه‌ای یافت نشد</option>";
                                            }
                                            ?>
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
<?php require_once '../../../footer.php';?>
