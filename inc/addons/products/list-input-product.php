<?php
$title_page = "لیست محصولات ورودی";
require_once '../../../header.php';
// Retrieve products input data from the database
$products_input_sql = "SELECT * FROM products_input";
$products_input_result = $connection->query($products_input_sql);
?>
<div class="main-content">
    <nav class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <?php if(isset($message_sec)){ ?>
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        محصولات با موفقیت وارد شدند
                    </div>
                </div>
            <?php } ?>
            <div class="card">
                <div class="card-header">
                    <h4>لیست محصولات ورودی</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-striped table-hover" id="tableExport" style="width:100%;text-align:center;">
                            <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>شناسه ورود</th>
                                    <th>تاریخ ورود</th>
                                    <th>ساعت</th>
                                    <th>ثبت کننده</th>
                                    <th>نام فروشنده</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($products_input_result->num_rows > 0) {
                                    $row_count = 1;
                                    while ($product_input_row = $products_input_result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row_count . '</td>';
                                        echo '<td>' . $product_input_row['entry_id'] . '</td>';
                                        echo '<td>' . $product_input_row['date'] . '</td>';
                                        echo '<td>' . $product_input_row['clock'] . '</td>';
                                        echo '<td>' . $product_input_row['user'] . '</td>';
                                        echo '<td>' . $product_input_row['foroshande_name'] . '</td>';
                                        echo '<td>'.'
                                        <a target="_blank" href="view-input.php?id=" class="btn btn-icon btn-success"><i class="fas fa-eye"></i></a>
                                        <a target="_blank" href="edit-input.php?id=" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                                        <a href="list-input-product.php?id=" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></a>
                                        '.'</td>';
                                        echo '</tr>';
                                        $row_count++;
                                    }
                                } else {
                                    echo '<tr><td colspan="13">هیچ محصول ورودی‌ای یافت نشد</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>

<?php require_once '../../../footer.php'; ?>
