<?php
$title_page = "لیست محصولات ورودی";
require_once '../../../header.php';

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $sql = "DELETE FROM products_input WHERE id = ? LIMIT 1";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $del_message = "True";
    } else {
        echo "خطا در حذف رکورد: " . $connection->error;
    }
}
if(isset($_POST['send'])){
    $entry_id = $_POST['entry_id'];
    $date_in = $_POST['date_in'];
    $date_out = $_POST['date_out'];

    $condition = ""; // افزودن این خط برای تعریف اولیه متغیر $condition

    if(!empty($entry_id)){
        if(!empty($condition)){
            $condition .= " AND ";
        }
        $condition .= "entry_id = '$entry_id'";
    }
    if(!empty($date_in)){
        if(!empty($condition)){
            $condition .= " AND ";
        }
        $condition .= "date >= '$date_in'";
    }
    if(!empty($date_out)){
        if(!empty($condition)){
            $condition .= " AND ";
        }
        $condition .= "date <= '$date_out'";
    }
    
    if(!empty($condition)){
        $condition = "WHERE ".$condition;
    }

    $products_input_sql = "SELECT * FROM products_input $condition";
    $products_input_result = $connection->query($products_input_sql);
}
?>

<div class="main-content">
    <nav class="row">
        <div class="col-12 col-md-12 col-lg-12">
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
                                if (isset($products_input_result) && $products_input_result->num_rows > 0) {
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
                                        <a target="_blank" href="view-input.php?id=' . $product_input_row['id'] . '" class="btn btn-icon btn-success"><i class="fas fa-eye"></i></a>
                                        <a target="_blank" href="edit-input.php?id=' . $product_input_row['id'] . '" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                                        <a href="list-input-product.php?del=' . $product_input_row['id'] . '" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></a>
                                        '.'</td>';
                                        echo '</tr>';
                                        $row_count++;
                                    }
                                } else {
                                    echo '<tr><td colspan="7">هیچ محصول ورودی‌ای یافت نشد</td></tr>';
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
