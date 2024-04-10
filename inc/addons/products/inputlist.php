<?php
$title_page = "جدول گزارش ورود محصول به انبار";
require_once '../../../header.php';

if (isset($_POST['send'])) {
    // اطلاعات ارسالی از فرم
    $username = $_POST['username'];
    $productName = $_POST['productName'];
    $date_in = $_POST['date_in'];
    $date_out = $_POST['date_out'];

    // آماده‌سازی و اجرای کوئری SELECT برای نمایش تمامی رکوردها با فیلترهای ارسالی از فرم
    $select_query = $connection->prepare("
        SELECT pi.*, p.product_name, u.username AS user_name, uby.username AS by_user_name
        FROM product_inputs pi
        LEFT JOIN products p ON pi.product_id = p.id
        LEFT JOIN users u ON pi.username = u.id
        LEFT JOIN users uby ON pi.by_member = uby.id
        WHERE
        (u.username = ? OR ? = '') AND
        (p.product_name = ? OR ? = '') AND
        (pi.date_input BETWEEN ? AND ? OR ? = '' OR ? = '')");
    $select_query->bind_param("ssssssss", $username, $username, $productName, $productName, $date_in, $date_out, $date_in, $date_out);
    $select_query->execute();
    $result = $select_query->get_result();

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
                                                <th>تاریخ ورود</th>
                                                <th>نام محصول</th>
                                                <th>تعداد</th>
                                                <th>واردکننده</th>
                                                <th>ثبت کننده</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['date_input'] . '</td>';
            echo '<td>' . $row['product_name'] . '</td>';
            echo '<td>' . $row['product_number'] . '</td>';
            echo '<td>' . $row['user_name'] . '</td>';
            echo '<td>' . $row['by_member'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</nav>
</div>';
    } else {
        echo '
            <div class="main-content">
                <nav class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>رکوردی یافت نشد</h4>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>';
    }
} else {
    echo 'شما دسترسی به این صفحه را ندارید';
}
require_once '../../../footer.php';
?>
