<?php
$title_page = "موجودی محصولات اولیه";
require_once '../../../header.php';

// تعریف متغیر برای شرط جستجو
$username = isset($_POST['username']) ? $_POST['username'] : '';

// تولید شرط WHERE بر اساس ورودی‌های فرم
$where_condition = !empty($username) ? "u.username = '$username'" : '';

// تولید کوئری نهایی با توجه به شرط
$user_stock_query = "SELECT u.username, pp.product_name, us.material_number, pp.productType, us.Surplus
                    FROM users u
                    LEFT JOIN users_stock us ON u.id = us.user_id
                    LEFT JOIN primaryproduct pp ON us.material_id = pp.id
                    " . ($where_condition ? "WHERE $where_condition" : "") . "
                    ORDER BY u.username, pp.product_name";

// اجرای کوئری
$user_stock_result = $connection->query($user_stock_query);
?>

<div class="main-content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>موجودی محصولات اولیه</h4>
                </div>
                <div class="card-body">
                    <?php
                    if ($user_stock_result->num_rows > 0) {
                        echo '<table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>نام کاربر</th>
                                        <th>نام محصول اولیه</th>
                                        <th>موجودی</th>
                                        <th>موجودی مازاد</th>
                                        <th>واحد</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        while ($row = $user_stock_result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['username'] . '</td>';
                            echo '<td>' . $row['product_name'] . '</td>';
                            echo '<td dir="ltr">' . $row['material_number'] . '</td>';
                            echo '<td dir="ltr">' . $row['Surplus'] . '</td>';
                            echo '<td>' . $row['productType'] . '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody></table>';
                    } else {
                        echo '<p>هیچ موجودی محصولات اولیه یافت نشد.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../../footer.php'; ?>
