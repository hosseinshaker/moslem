<?php
$title_page = "خروج محصول از انبار";
require_once '../../../header.php';
if (isset($_POST['insert'])) {
    $user_name_id = $_POST['user_name'];
    $product_id = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $idoutpout = $_POST['idoutpout'];
    $date_output = $_POST['date_output'];
    $product_pattern = $_POST['product_pattern'];
    $product_color = $_POST['product_color'];
    $materials = $_POST['materials'];
    $material_ids = [];
    $material_quantities = [];
    $material_name_to_id = array();
    $material_query = $connection->query("SELECT id, product_name FROM primaryproduct");
    $material_result = $material_query->fetch_all(MYSQLI_ASSOC);
    foreach ($material_result as $row) {
        $material_name_to_id[$row['product_name']] = $row['id'];
    }
    $user_query = $connection->query("SELECT id FROM users WHERE id = '$user_name_id'");
    $user_result = $user_query->num_rows;
    if ($user_result == 0) {
        $connection->query("INSERT INTO users (id, username) VALUES ('$user_name_id', '$user_name_id')");
    }
    $product_name_query = $connection->query("SELECT product_name FROM products WHERE id = '$product_id'");
    $product_name_result = $product_name_query->num_rows;
    if ($product_name_result == 0) {
        $connection->query("INSERT INTO products (id, product_name) VALUES ('$product_id', '$product_id')");
    }
    $isStockSufficient = true;
    foreach ($materials as $material_name => $deduct_quantity) {
        if (isset($material_name_to_id[$material_name])) {
            $material_id = $material_name_to_id[$material_name];
            $check_stock_query = $connection->query("SELECT productCount FROM primaryproduct WHERE id = '$material_id'");
            $check_stock_result = $check_stock_query->num_rows;
            if ($check_stock_result > 0) {
                $stock_row = $check_stock_query->fetch_assoc();
                if ($stock_row['productCount'] < $deduct_quantity) {
                    $isStockSufficient = false;
                    break;
                }
            } else {  
                $isStockSufficient = false;
                break;
            }
        } else {
            $isStockSufficient = false;
            break;
        }
    }
    if ($isStockSufficient) {
        $updated_materials = [];
        foreach ($materials as $material_name => $deduct_quantity) {
            $material_id = $material_name_to_id[$material_name];  // تبدیل نام ماده به شناسه ماده
            $updated_materials[$material_id] = $deduct_quantity;
            // به‌روزرسانی موجودی محصولات اولیه
            $connection->query("UPDATE primaryproduct SET productCount = productCount - $deduct_quantity WHERE id = '$material_id'");
        }
        $materials_json = json_encode($updated_materials, JSON_UNESCAPED_UNICODE);
        $user_name = $_SESSION['username']; // فرض بر این است که نام کاربری در سشن موجود است
        // ثبت اطلاعات خروج محصول
        $connection->query("INSERT INTO product_outputs (date_output, product_id, quantity, materials, by_member, idoutput, username, product_pattern, product_color) VALUES ('$date_output', '$product_id', '$quantity', '$materials_json', '$user_name', '$idoutpout', '$user_name_id', '$product_pattern', '$product_color')");
        // ثبت اطلاعات در انبار کاربر
        foreach ($materials as $material_name => $material_number) {
            $material_id = $material_name_to_id[$material_name];
            $check_record_query = $connection->query("SELECT * FROM users_stock WHERE user_id = '$user_name_id' AND material_id = '$material_id'");
            $check_record_result = $check_record_query->num_rows;
            if ($check_record_result > 0) {
        $connection->query("UPDATE users_stock SET material_number = material_number + $material_number WHERE user_id = '$user_name_id' AND material_id = '$material_id'");
            } else {
            $connection->query("INSERT INTO users_stock (user_id, material_id, material_number) VALUES ('$user_name_id', '$material_id', '$material_number')");
            }
            $match_found = false;
            foreach ($_POST['materials_req'] as $material_def_id => $material_def_quantity) {
                if ($material_def_id == $material_id) {
                    $total = $material_number - $material_def_quantity;
                    // اگر total مثبت باشد
                    if ($total > 0) {
                        $connection->query("UPDATE users_stock SET Surplus = Surplus + $total WHERE user_id = '$user_name_id' AND material_id = '$material_id'");
                    }
                    // اگر total منفی باشد
                    elseif ($total < 0) {
                        $total_abs = abs($total);
                        // دریافت مقدار موجودی مازاد
                        $surplus_query = $connection->query("SELECT Surplus FROM users_stock WHERE user_id = '$user_name_id' AND material_id = '$material_id'");
                        $surplus_row = $surplus_query->fetch_assoc();
                        $surplus = $surplus_row['Surplus'];
            
                        // بررسی آیا موجودی مازاد کافی است
                        if ($surplus >= $total_abs) {
                            // بررسی مقدار موجودی کل قبل از اضافه کردن
                            $material_query = $connection->query("SELECT material_number FROM users_stock WHERE user_id = '$user_name_id' AND material_id = '$material_id'");
                            $material_row = $material_query->fetch_assoc();
                            $current_material_number = $material_row['material_number'];
            
                            // اگر موجودی مازاد بیشتر از صفر بود
                            if ($current_material_number >= 0) {
                                // کم کردن کل مقدار نیاز از موجودی مازاد و اضافه کردن به موجودی کل
                                $connection->query("UPDATE users_stock SET Surplus = Surplus - $total_abs, material_number = material_number + $total_abs WHERE user_id = '$user_name_id' AND material_id = '$material_id'");
                            } else {
                                // موجودی منفی نباشد
                                // کم کردن به اندازه موجودی مازاد و اضافه کردن به موجودی کل
                                $connection->query("UPDATE users_stock SET Surplus = 0, material_number = material_number + $surplus WHERE user_id = '$user_name_id' AND material_id = '$material_id'");
                                // کم کردن مقدار کمبود از موجودی مازاد
                                $shortage = $total_abs - $surplus;
                                $connection->query("UPDATE users_stock SET Surplus = Surplus - $shortage WHERE user_id = '$user_name_id' AND material_id = '$material_id'");
                            }
                        } else {
                            // موجودی مازاد کافی نباشد
                            // کم کردن به اندازه موجودی مازاد و اضافه کردن به موجودی کل
                            $connection->query("UPDATE users_stock SET Surplus = Surplus - $total_abs, material_number = material_number + $surplus WHERE user_id = '$user_name_id' AND material_id = '$material_id'");
                        }
                    }
                    $match_found = true;
                    break;
                }
            }
            if (!$match_found) {
                echo 'شناسه اشتباه ارور 10';
            }
    // دریافت نام محصول خروجی
    $output_product_query = $connection->query("SELECT product_name FROM products WHERE id = '$product_id'");
    $output_product_result = $output_product_query->fetch_assoc();
    $output_product_name = $output_product_result['product_name'];
 // دریافت نام کاربر بر اساس شناسه کاربر
 $user_name_query = $connection->query("SELECT username FROM users WHERE id = '$user_name_id'");
 $user_name_result = $user_name_query->fetch_assoc();
 $receiver_name = $user_name_result['username'];
        }
            echo '    <div class="main-content">
            <nav class="row">
            <nav class="col-12 col-md-12 col-lg-12">
            <div class="card">
            <div class="card-header">
                <h4>جدول گزارشات</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
            <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
            ';
        echo "
        <thead>
        <tr>
            <th>شناسه خروج</th>
            <th>نام محصول خروجی</th>
            <th>تعداد محصول خروجی</th>
            <th>نام گیرنده</th>
            <th>محصولات اولیه و تعداد</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>$idoutpout</td>
            <td>$output_product_name</td>
            <td>$quantity</td>
            <td>$receiver_name</td>
            <td>";
            if(!empty($materials)){
                foreach ($materials as $material_name => $material_number) {
                    echo "$material_name: $material_number<br>";
                }
            }

echo "</td></tbody></tr></table></nav></nav></div></div>
</div>
</div>";
    } else {
        $low_material = "موجودی محصولات اولیه کافی نیست.";
    }
}
if (isset($_POST['calculate'])) {
    $product_id = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $idoutpout = rand(100, 9999999999);
    $user_name = $_POST['user_name'];
    $date_output = $_POST['date_output'];
    $product_color = $_POST['product_color'];
    $product_pattern = $_POST['product_pattern'];
    $product_query = "SELECT * FROM products WHERE id = $product_id";
    $product_result = $connection->query($product_query);
    if ($product_result && $product_result->num_rows > 0) {
        $product_row = $product_result->fetch_assoc();
        $product_name = $product_row['product_name'];
        $material_query = "SELECT * FROM product_materials WHERE product_id = $product_id";
        $material_result = $connection->query($material_query);
        if ($material_result && $material_result->num_rows > 0) {
            $requiredMaterials = array();
            while ($material_row = $material_result->fetch_assoc()) {
                $material_id = $material_row['material_id'];
                $required_quantity = $material_row['quantity'] * $quantity;
                $material_name_query = "SELECT product_name, productType,id FROM primaryproduct WHERE id = $material_id";
                $material_name_result = $connection->query($material_name_query);
                if ($material_name_result && $material_name_result->num_rows > 0) {
                    $material_name_row = $material_name_result->fetch_assoc();
                    $material_name = $material_name_row['product_name'];
                    $material_type = $material_name_row['productType'];
                    $material_id_org = $material_name_row['id'];
                    // دریافت اطلاعات موجودی انبار کاربر
                    $user_stock_query = $connection->query("SELECT * FROM users_stock WHERE user_id = '$user_name' AND material_id = '$material_id'");
                    $user_stock_result = $user_stock_query->fetch_assoc();
                    $user_stock_quantity = ($user_stock_result) ? $user_stock_result['material_number'] : 0;

                    $requiredMaterials[$material_name] = array('quantity' => $required_quantity, 'unit' => $material_type, 'stock' => $user_stock_quantity,'id_org'=>$material_id_org);
                } else {
                    echo "مواد اولیه مورد نیاز یافت نشد.";
                    break;
                }
            }
            echo '<div class="main-content">
                    <nav class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>نیاز به مواد اولیه برای تولید ' . $quantity . ' عدد ' . $product_name . ':</h4>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <input type="hidden" name="product_name" value="' . $product_id . '">
                                        <input type="hidden" name="quantity" value="' . $quantity . '">
                                        <input type="hidden" name="idoutpout" value="' .$idoutpout . '">
                                        <input type="hidden" name="user_name" value="' . $user_name . '">
                                        <input type="hidden" name="date_output" value="' . $date_output . '">
                                        <input type="hidden" name="product_color" value="' . $product_color . '">
                                        <input type="hidden" name="product_pattern" value="' . $product_pattern . '">
                                        <div class="form-group">
                                        <label>مواد اولیه مورد نیاز:</label>
                                    </div>';
                                    foreach ($requiredMaterials as $material_name => $material_info) {
                                           // افزودن input پنهان برای ذخیره مقدار مورد نیاز هر ماده اولیه
                                           echo '<input type="hidden" name="materials_req[' . $material_info['id_org'] . ']" value="' . $material_info['quantity'] . '">';
                                        // این بخش را به داخل حلقه foreach منتقل کرده‌ایم
                                        $material_id_query = $connection->query("SELECT id FROM primaryproduct WHERE product_name = '$material_name'");
                                        $material_id_result = $material_id_query->fetch_assoc();
                                        $material_id = $material_id_result['id'];
                                        // دریافت اطلاعات موجودی انبار کاربر و موجودی مازاد
                                        $user_stock_query = $connection->query("SELECT material_number, surplus FROM users_stock WHERE user_id = '$user_name' AND material_id = '$material_id'");
                                        $user_stock_result = $user_stock_query->fetch_assoc();
                                        $user_stock_quantity = ($user_stock_result) ? $user_stock_result['material_number'] : 0;
                                        $surplus_quantity = ($user_stock_result) ? $user_stock_result['surplus'] : 0;
                                        $surplus_class = ($surplus_quantity < 0) ? 'class="text-danger"' : 'class="text-success"';

                                        echo '<div class="form-group">
                                        <label for="material_' . $material_name . '">' . $material_name . ' (' . $material_info['unit'] . ') - موجودی: ' . $user_stock_quantity . ' >> موجودی مازاد: <span ' . $surplus_class . '>' . $surplus_quantity . '</span>:</label>
                                        <input type="text" class="form-control" name="materials[' . $material_name . ']" value="' . $material_info['quantity'] . '" />
                                            </div>';
                                    }
                                    echo '<div class="form-group">
                                            <button type="submit" name="insert" class="btn btn-primary">تایید</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>';
    } else {
        echo "مواد اولیه برای این محصول تعریف نشده‌اند.";
    }
} else {
    echo "محصول انتخاب شده یافت نشد.";
}
}                     
if (!empty($low_material)) {
    echo '
    <div class="main-content">
    <nav class="row">
    <nav class="col-12 col-md-12 col-lg-12">
    <div class="alert alert-danger alert-dismissible show fade">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>×</span>
                            </button>
    ';
    echo $low_material;
    echo '
    </div>
    </div>
</nav>
</nav>
</div>
    ';
}
require_once '../../../footer.php';
?>
