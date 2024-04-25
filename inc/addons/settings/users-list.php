<?php
$title_page = "لیست کاربران سامانه";
require_once '../../../header.php';

// دریافت لیست کاربران از دیتابیس
$query = "SELECT * FROM admintable";
$result = $connection->query($query);
// بررسی درخواست GET برای حذف کاربر
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete'])) {
    $userId = $_GET['delete'];

    // دستور SQL برای حذف کاربر
    $deleteSql = "DELETE FROM admintable WHERE id = ?";
    $deleteStmt = $connection->prepare($deleteSql);
    $deleteStmt->bind_param("i", $userId);

    // اجرای دستور و بررسی نتیجه
    if ($deleteStmt->execute()) {
        echo "<p>کاربر با موفقیت حذف شد.</p>";
    } else {
        echo "<p>خطا در حذف کاربر: " . $deleteStmt->error . "</p>";
    }

    $deleteStmt->close();
}

// دستور SQL برای گرفتن لیست کاربران
$sql = "SELECT * FROM admintable";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    // نمایش جدول کاربران
    echo '
    <div class="col-12">
    <div class="main-content">
    <div class="card">
    <div class="card-body">
      
    <div class="row"><table class="table table-striped table-hover" id="tableExport" style="width:100%;">';
    echo "
    <tr><th>نام کاربری</th><th>نام</th><th>ویرایش</th><th>حذف</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["username"]. "</td><td>" . $row["name"]. "</td>";
        echo "<td><a class='btn btn-icon btn-primary' href='edit-user.php?id=" . $row["id"] . "'><i class='far fa-edit'></i></a></td>";
        echo "<td><a class='btn btn-icon btn-danger'  href='?delete=" . $row["id"] . "'><i class='fas fa-times'></a></td></tr>";
    }
    echo "</table>";
    echo '    </div>
    </div></div>
    </div>'
    ;
} else {
    echo "هیچ کاربری یافت نشد";
}

$connection->close();
// نمایش لیست کاربران در جدول
?>


<?php require_once '../../../footer.php';?>
