<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("HTTP/1.0 404 Not Found");
    exit;
}
$title_page = "نمایش گزارش محصولات اولیه";
require_once '../../../header.php';

// بررسی اینکه آیا درخواست POST ارسال شده است
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // دریافت فیلترها از فرم ارسالی
    $productName = isset($_POST['productName']) ? $_POST['productName'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $date_in = isset($_POST['date_in']) ? $_POST['date_in'] : '';
    $date_out = isset($_POST['date_out']) ? $_POST['date_out'] : '';

    // ساخت دستور SQL برای فیلتر کردن گزارش‌ها
    $sql = "SELECT * FROM PrimaryProductReport WHERE 1";
    if (!empty($productName)) {
        $sql .= " AND productName = '$productName'";
    }
    if (!empty($status)) {
        $sql .= " AND status = '$status'";
    }
    if (!empty($date_in)) {
        $sql .= " AND date >= '$date_in'";
    }
    if (!empty($date_out)) {
        $sql .= " AND date <= '$date_out'";
    }
    $result = $connection->query($sql);
} else {

    exit;
}
?>

<div class="main-content">
    <nav class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>جدول گزارش محصولات اولیه</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?php if ($result->num_rows > 0) : ?>
                            <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>نام محصول</th>
                                        <th>طرح</th>
                                        <th>رنگ</th>
                                        <th>تاریخ</th>
                                        <th>کاربر</th>
                                        <th>وضعیت</th>
                                        <th>تعداد</th>
                                        <th>موجودی </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?php echo $row['productName']; ?></td>
                                            <td><?php echo $row['productPattern']; ?></td>
                                            <td><?php echo $row['productColor']; ?></td>
                                            <td><?php echo $row['date']; ?></td>
                                            <td><?php echo $row['user']; ?></td>
                                            <td><?php echo $row['status'] == 'deduction' ? 'کاهش' : 'افزایش'; ?></td>
                                            <td><?php echo $row['value']; ?></td>
                                            <td><?php echo $row['stock']; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <div class="alert alert-info">
                                هیچ گزارشی یافت نشد.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>

<?php require_once '../../../footer.php'; ?>
