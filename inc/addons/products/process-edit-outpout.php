<?php
require_once '../../../header.php';
if (isset($_POST['updated'])) {
    $update_id = $_POST['record_id'];//شناسهرکورد در انبار خروجی که قرار است آپدیت شود
    $user_name_id = $_POST['user_name'];//نام کاربر یا خیاط
    $product_id = $_POST['product_name'];//شناسه محصول اصلی
    $new_quantity = $_POST['quantity'];//مقدار جدید محصول
    $date_output = $_POST['date_output'];//تاریخ خروج
    $product_pattern = $_POST['product_pattern'];//طرح محصول
    $product_color = $_POST['product_color'];//رنگ محصول
    $materials = $_POST['materials'];//محصول های اولیه و تعداد آنها 
    $materials_old = $_POST['materials_old'];//محصول های اولیه قدیم و تعداد آنها
    $areEqual = true;//شرط برابر بودن تعداد محصولات اولیه قدیم و جدید 


//محاسبه مقدار محصول اولیه محصول از دیتابیس
$query = "SELECT material_id, quantity FROM product_materials WHERE product_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$materials_required = [];
while($row = $result->fetch_assoc()) {
    $material_id = $row['material_id'];
    $quantity_needed_per_product = $row['quantity'];
    $total_quantity_needed = $quantity_needed_per_product * $new_quantity;
    $materials_required[$material_id] = $total_quantity_needed;
}


foreach ($materials as $material_id => $material_quantity) {
    $material_old_quantity = isset($materials_old[$material_id]) ? $materials_old[$material_id] : 0;

    if ($material_quantity > $material_old_quantity) {
        echo "مقدار جدید برای ماده اولیه با شناسه $material_id بیشتر است. ";
        $difference = $material_quantity - $material_old_quantity;
        echo "اختلاف: $difference<br>";
        $materials_json = json_encode($updated_materials, JSON_UNESCAPED_UNICODE);
        $queryUpdateOutput = "UPDATE product_outputs  SET quantity = '$new_quantity', materials = '$materials_json', by_member = '$user_name', username = '$user_name_id'  WHERE idoutput = $idoutpout";

if ($connection->query($queryUpdateOutput) === TRUE) {
echo "رکورد گزارش به‌روز شد.<br>";
} else {
echo "خطا در به‌روزرسانی گزارش: " . $connection->error;
}

// اجرای استعلام آپدیت
if ($stmtUpdateOutput->execute()) {
echo "رکورد گزارش به‌روز شد.<br>";
} else {
echo "خطا در به‌روزرسانی گزارش: ";
}




        // افزودن مقدار اختلاف به انبار کاربر
        $queryAddToInventory = "UPDATE users_stock SET material_number = material_number + $difference WHERE user_id = $user_name_id AND material_id = $material_id";
        if ($connection->query($queryAddToInventory) === TRUE) {
            echo "اطلاعات انبار به‌روز شد.<br>";
        } else {
            echo "خطا در به‌روزرسانی انبار: " . $connection->error;
        }
    }
     elseif ($material_quantity < $material_old_quantity) {
        echo "مقدار جدید برای ماده اولیه با شناسه $material_id کمتر است. ";
        $difference = $material_old_quantity - $material_quantity;
        echo "اختلاف: $difference<br>";
    } else {
        echo "مقدار ماده اولیه با شناسه $material_id تغییری نکرده است.<br>";
    }
}

    }
require_once '../../../footer.php';