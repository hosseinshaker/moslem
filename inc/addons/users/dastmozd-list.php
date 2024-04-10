<?php
$title_page = "مشاهده حقوق هر کاربر";
require_once '../../../header.php';

// بررسی اینکه آیا فرم ارسال شده است
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $date_in = $_POST['date_in'];
    $date_out = $_POST['date_out'];

    // کوئری برای دریافت شناسه کاربر از جدول users
    $getUserIDQuery = "SELECT id FROM users WHERE username = ?";
    $stmtUserID = $connection->prepare($getUserIDQuery);
    $stmtUserID->bind_param("s", $username);
    $stmtUserID->execute();
    $resultUserID = $stmtUserID->get_result();

    if ($resultUserID->num_rows > 0) {
        $rowUserID = $resultUserID->fetch_assoc();
        $userID = $rowUserID['id'];

        // کوئری برای دریافت داده‌ها از جدول product_inputs و products
        $query = "SELECT p.product_name, p.salary, SUM(i.product_number) as product_count, (p.salary * SUM(i.product_number)) as total_salary 
        FROM product_inputs i 
        INNER JOIN products p ON i.product_id = p.id 
        WHERE i.date_input BETWEEN ? AND ? AND i.username = ?
        GROUP BY i.product_id";

        // آماده‌سازی و اجرای کوئری
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ssi", $date_in, $date_out, $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // نمایش داده‌ها
            $totalSalarySum = 0; // افزودن یک متغیر برای محاسبه جمع کل حقوق

            ?>

<div class="main-content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>حقوق کاربر: <?php echo $username; ?></h4>
                </div>
                <div class="card-body">
<?php
            echo '<table class="table table-striped table-hover" id="tableExport" style="width:100%;">
            <thead>';
            echo "<tr><th>نام محصول</th><th>حقوق به ازای هر محصول</th><th>تعداد</th><th>حقوق کل</th></tr></thead><tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["product_name"] . "</td><td class='num'>" . $row["salary"] . "</td><td>" . $row["product_count"] . "</td><td class='num'>" . $row["total_salary"] . "</td></tr>";
                $totalSalarySum += $row["total_salary"]; // اضافه کردن حقوق هر سطر به مجموع کل
            }
            echo "<tr><td>جمع کل حقوق</td><td></td><td></td><td class='num'>" . $totalSalarySum . "</td></tr>";
            echo "</tbody>";
            echo "</table>";
            ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
        } else {
            echo "هیچ نتیجه‌ای یافت نشد";
        }

        $stmt->close();
    } else {
        echo "شناسه کاربر یافت نشد";
    }

    $stmtUserID->close();
} else {
    echo "فرم ارسال نشده است.";
}
?>

<script>
    // تابع برای جدا کردن اعداد به صورت سه رقمی در عناصر td با کلاس 123
    function formatNumbers() {
        var cells = document.querySelectorAll('.num'); // انتخاب تمام عناصر td با کلاس 123

        cells.forEach(function (cell) {
            var number = cell.innerHTML;
            if (!isNaN(number) && number.trim() !== '') {
                cell.innerHTML = parseInt(number).toLocaleString('fa-IR'); // فرمت به صورت ۳ رقم ۳ رقم
            }
        });
    }

    window.onload = formatNumbers; // اجرای تابع هنگام بارگذاری صفحه
</script>
<?php
require_once '../../../footer.php';
?>
