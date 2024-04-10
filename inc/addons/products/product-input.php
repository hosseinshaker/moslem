<?php
$title_page = "ورود محصول به انبار";
require_once '../../../header.php';
// نمایش محصولات
$sql_products = "SELECT * FROM products";
$result_products = $connection->query($sql_products);
// نمایش کاربران
$sql_users = "SELECT * FROM users";
$result_user = $connection->query($sql_users);
// فرم ورودی محصول
// بررسی ارسال فرم
if (isset($_POST['calculate'])) {
    // دریافت اطلاعات از فرم
    $date_input = $_POST['date_input'];
    $product_id = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $output_id = $_POST['output_id'];
    $user_id = $_POST['user_name'];
    $user_name=$_SESSION['username']; // اطلاعات کاربر از سشن دریافت می‌شود
    $insertdata=0;

    $product_id = $_POST['product_name']; // شناسه محصول
    $quantity = $_POST['quantity']; // تعداد محصول

    // دریافت اطلاعات محصول از دیتابیس
    $product_query = $connection->prepare("SELECT * FROM products WHERE id = ?");
    $product_query->bind_param("i", $product_id);
    $product_query->execute();
    $product_result = $product_query->get_result();

    if ($product_result->num_rows > 0) {
        $product_row = $product_result->fetch_assoc();
        $product_name = $product_row['product_name'];

        // دریافت مواد اولیه محصول از دیتابیس
        $materials_query = $connection->prepare("SELECT pm.quantity, pp.product_name, pp.productType
                                                FROM product_materials pm
                                                JOIN primaryproduct pp ON pm.material_id = pp.id
                                                WHERE pm.product_id = ?");
        $materials_query->bind_param("i", $product_id);
        $materials_query->execute();
        $materials_result = $materials_query->get_result();

        $requiredMaterials = [];

        if ($materials_result->num_rows > 0) {
            while ($material_row = $materials_result->fetch_assoc()) {
                $material_name = $material_row['product_name'];
                $material_quantity = $material_row['quantity'] * $quantity;
                $material_type = $material_row['productType'];

                $requiredMaterials[$material_name] = [
                    'quantity' => $material_quantity,
                    'unit' => $material_type
                ];
            }
        } else {
            echo '<div class="alert alert-info">مواد اولیه برای محصول مورد نظر یافت نشد.</div>';
        }

        if (!empty($requiredMaterials)) {

function getMaterialIdByName($materialName, $connection) {
    $query = $connection->prepare("SELECT id FROM primaryproduct WHERE product_name = ?");
    $query->bind_param("s", $materialName);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id'];
    }

    return null;
}

// اجرای تغییرات در حلقه مورد نظر
foreach ($requiredMaterials as $material_name => $material_info) {
    // دریافت شناسه محصول اولیه بر اساس نام
    $material_id = getMaterialIdByName($material_name, $connection);

    if ($material_id !== null) {
        // بررسی وجود مواد اولیه در انبار کاربر
        $stock_query = $connection->prepare("SELECT material_number FROM users_stock WHERE user_id = ? AND material_id = ?");
        $stock_query->bind_param("ii", $user_id, $material_id);
        $stock_query->execute();
        $stock_result = $stock_query->get_result();

        if ($stock_result->num_rows > 0) {
            $stock_row = $stock_result->fetch_assoc();
            $current_stock = $stock_row['material_number'];

            // کاهش موجودی مواد اولیه، بدون در نظر گرفتن موجودی فعلی
            $new_stock = $current_stock - $material_info['quantity'];
            $update_stock_query = $connection->prepare("UPDATE users_stock SET material_number = ? WHERE user_id = ? AND material_id = ?");
            $update_stock_query->bind_param("iii", $new_stock, $user_id, $material_id);
            $update_stock_query->execute();
            $update_stock_query->close();
            $insertdata=1;
        } else {
            // اگر رکوردی برای ماده اولیه وجود ندارد
           $error_1= '<div class="alert alert-warning">محصول اولیه ' . $material_name . ' در انبار کاربر تعریف نشده است.</div>';
           $insertdata=0;
        }






        $stock_query->close();
    } else {
        // اگر شناسه محصول برای نام محصول یافت نشد
        echo '<div class="alert alert-warning">شناسه محصول برای ' . $material_name . ' یافت نشد.</div>';
    }
}

        }
    } else {
        echo '
        <div class="main-content">
            <nav class="row">
                <div class="col-12">
                <div class="alert alert-success">
        
        <div class="alert alert-info">محصول مورد نظر یافت نشد.</div>  </div>
        </div>
        </div>
        </nav>
        </div>';
    }
    if($insertdata===1){
        $insert_query = $connection->prepare("INSERT INTO product_inputs (date_input, product_id, product_number, idoutput, username,by_member) VALUES (?, ?, ?, ?, ?,?)");
        $insert_query->bind_param("siiiss", $date_input, $product_id, $quantity, $output_id, $user_id,$user_name);
        // اجرای کوئری و بررسی موفقیت
        if ($insert_query->execute()) {
           $succ_mes=' <div class="alert alert-success">محصول مورد نظر وارد  شد.  </div>';
        } else {
            echo '<div class="alert alert-danger">خطا در ثبت محصول. لطفاً مجدداً تلاش کنید.</div>';
        }
        // بستن اتصال و کوئری
        $insert_query->close();
    }
}
?>
<div class="main-content">
                    <nav class="row">
                        <div class="col-12">
                            <?php
if(!empty(  $succ_mes)){
echo   $succ_mes;
}
   ?>
            <?php
if(!empty(  $error_1)){
echo   $error_1;
}
   ?>
                                <form method="post">
                <div class="card">
                    <div class="card-header">
                        <h4>ورود محصول به انبار</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>تاریخ ورود به انبار</label>
                            <input  id="datepicker-check-in" name="date_input" class="form-control"required>
                        </div>
                        <div class="form-group">
                            <label>انتخاب محصول  </label>
                            <div id="materialContainer">
                                <div class="materialGroup">
                                    <select name="product_name" class="form-control select2" required>
                                        <option value="">انتخاب*</option>
                                        <?php
                                        if ($result_products->num_rows > 0) {
                                            while ($row = $result_products->fetch_assoc()) {
                                                echo '<option value="' . $row['id'] . '">' . $row['product_name'] . '</option>';
                                            }
                                        } else {
                                            echo "<option value=''>نتیجه‌ای یافت نشد</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="form-group">
                                        <label>تعداد محصول</label>
                                        <input type="number" class="form-control" placeholder="مقدار" name="quantity" required>
                                    </div>


                                    <div class="form-group">
                                        <label>شناسه خروج</label>
                                        <input type="number" class="form-control" placeholder="شناسه ای که موقع خروج از انبار دریافت کردید" name="output_id" required>
                                    </div>

 <div class="form-group">
    <label>نام مونتاژکننده/خیاط</label>
    <select name="user_name" class="form-control select2" required>
        <option value="">انتخاب*</option>
        <?php
        if ($result_user->num_rows > 0) {
            while ($user_row = $result_user->fetch_assoc()) {
                echo '<option value="' . $user_row['id'] . '">' . $user_row['username'] . '</option>';
            }
        } else {
            echo "<option value=''>نتیجه‌ای یافت نشد</option>";
        }
        ?>
    </select>
</div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" name="calculate">ورود محصول</button>
                    </div>
                </div>
            </form>
                    </nav>
                </div>
<?php
require_once '../../../footer.php';
?>