<?php
require_once '../../../database.php';
// بررسی اتصال
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// دریافت داده‌های محصولات از جدول محصولات
$sql = "SELECT productqr, product_name FROM products";
$result = $connection->query($sql);

// اگر داده‌ها موجود بودند
if ($result->num_rows > 0) {
    $products = array();
    // گرفتن هر ردیف داده به صورت آرایه
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    // خروجی دادن داده‌ها به صورت JSON
    echo json_encode(array("success" => true, "products" => $products));
} else {
    // در صورت عدم وجود داده
    echo json_encode(array("success" => false, "message" => "No products found."));
}

// بستن اتصال به پایگاه داده
$connection->close();
?>
