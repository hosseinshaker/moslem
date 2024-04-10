<?php
$title_page = "جدول گزارش خروج محصول از انبار";
require_once '../../../header.php';

if (isset($_POST['send'])) {
    // اطلاعات ارسالی از فرم
    $username = $_POST['username'];
    $productName = $_POST['productName'];
    $date_in = $_POST['date_in'];
    $date_out = $_POST['date_out'];
// آماده‌سازی و اجرای کوئری SELECT برای نمایش تمامی رکوردها با فیلترهای ارسالی از فرم
$select_query = $connection->prepare("
    SELECT po.*, p.product_name, u.username AS user_name, uby.username AS by_user_name, po.product_pattern, po.product_color
    FROM product_outputs po
    LEFT JOIN products p ON po.product_id = p.id
    LEFT JOIN users u ON po.username = u.id
    LEFT JOIN users uby ON po.by_member = uby.id
    WHERE
    (u.username = ? OR ? = '') AND
    (p.product_name = ? OR ? = '') AND
    (po.date_output BETWEEN ? AND ? OR ? = '' OR ? = '')");
$select_query->bind_param("ssssssss", $username, $username, $productName, $productName, $date_in, $date_out, $date_in, $date_out);
$select_query->execute();
$result = $select_query->get_result();
$total_quantity = 0; // اینیشیالایز متغیر برای جمع کل
if ($result->num_rows > 0) {  
    echo '
        <div class="main-content">
            <nav class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>جدول گزارشات</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>تاریخ خروج</th>
                                            <th>نام محصول</th>
                                            <th>تعداد</th>
                                            <th>رنگ</th>
                                            <th>طرح</th>
                                            <th>مواد مصرفی</th>
                                            <th>خیاط</th>
                                            <th>ثبت کننده</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['date_output'] . '</td>';
        echo '<td>' . $row['product_name'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>' . $row['product_color'] . '</td>';  // نمایش رنگ
        echo '<td>' . $row['product_pattern'] . '</td>';  // نمایش طرح
        // تجزیه و تحلیل مواد مصرفی
        $materials_array = json_decode($row['materials'], true);
        $materials_names = "";
        foreach ($materials_array as $material_id => $material_quantity) {
            $material_query = $connection->prepare("SELECT product_name FROM primaryproduct WHERE id = ?");
            $material_query->bind_param("i", $material_id);
            $material_query->execute();
            $material_result = $material_query->get_result();
            $material_name = $material_result->fetch_assoc()['product_name'];
            $materials_names .= "$material_name: $material_quantity<br>";
        }
        echo '<td>' . $materials_names . '</td>';
        echo '<td>' . $row['user_name'] . '</td>';
        echo '<td>' . $row['by_member'] . '</td>';
        echo '</tr>';
        $total_quantity += $row['quantity']; // اضافه کردن تعداد به جمع کل
    }
    echo '<tr>';
    echo '<td> جمع کل محصولات خروجی</td>';
    echo '<td>' . $total_quantity . ' عدد</td>';
    echo '<td></td>'; // تعداد ستون‌های باقی‌مانده
    echo '<td></td>'; // تعداد ستون‌های باقی‌مانده
    echo '<td></td>'; // تعداد ستون‌های باقی‌مانده
    echo '<td></td>'; // تعداد ستون‌های باقی‌مانده
    echo '<td></td>'; // تعداد ستون‌های باقی‌مانده
    echo '<td></td>'; // تعداد ستون‌های باقی‌مانده
    echo '</tr>';
    echo '</tbody>';
echo'
            </table>
        </div>
    </div>
</div>
</div>
</div>
</nav>
</div>';
}else{
    echo '  <div class="main-content">
    <nav class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>رکوردی یافت نشد</h4>
                </div>
                </div>
                </div>
                </nav>
                ';
}
}else {
    echo 'شما دسترسی به این صفحه را ندارید';
}
?>
<?php
require_once '../../../footer.php';
?>