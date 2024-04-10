 <?php
$title_page = "فرم مشاهده  موجودی کاربران";
require_once '../../../header.php';
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
                        <h4>فرم مشاهده موجودی کاربران</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="stock.php">
                            <nav class="form-row">
                                <nav class="form-group col-md-8">

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
