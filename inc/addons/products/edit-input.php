<?php
$title_page = "ویرایش محصولات وارد شده";
require_once '../../../header.php';

if(isset($_POST['update'])) {
    // Extract form data
    $entry_id = $_POST['entry_id'];
    $entry_date = $_POST['entry_date'];
    $clock = $_POST['clock'];
    $user = $_POST['user'];
    $foroshande_name = $_POST['foroshande_name'];
    $foroshande_phone = $_POST['foroshande_phone'];
    $name_ranande = $_POST['name_ranande'];
    $phone_ranande = $_POST['phone_ranande'];
    $pelak_khodro = $_POST['pelak_khodro'];
    $comment = $_POST['comment'];

    // Update entry in database
    $update_sql = "UPDATE products_input SET date = '$entry_date', clock = '$clock', user = '$user', foroshande_name = '$foroshande_name', foroshande_phone = '$foroshande_phone', name_ranande = '$name_ranande', phone_ranande = '$phone_ranande', pelak_khodro = '$pelak_khodro', comment = '$comment' WHERE entry_id = '$entry_id'";
    $connection->query($update_sql);

    // استخراج اطلاعات محصولات ورودی از دیتابیس
    $products_input_sql = "SELECT * FROM products_input WHERE entry_id = '$entry_id'";
    $products_input_result = $connection->query($products_input_sql);

    if($products_input_result->num_rows > 0) {
        $products_input_row = $products_input_result->fetch_assoc();
        // تبدیل داده‌های JSON به آرایه
        $products_data_db = json_decode($products_input_row['product_data'], true);

        // محصولاتی که از فرم ارسال شده است
        $products_form = $_POST['productName']; // نام محصولات ارسال شده از فرم
        $quantities_form = $_POST['productQuantity']; // مقادیر محصولات ارسال شده از فرم

        // مقدار موجودی محصولات قبل از ارسال فرم
        $previous_quantities = array_column($products_data_db, 'quantity');

        // محصولاتی که از دیتابیس حذف شده اما در فرم موجود نیستند
        $deleted_products = array_diff(array_column($products_data_db, 'productqr'), $products_form);

        // کاهش موجودی محصولات حذف شده از فرم
        foreach($deleted_products as $deleted_product) {
            // حذف محصول از آرایه محصولات و مقادیر آن
            $key = array_search($deleted_product, array_column($products_data_db, 'productqr'));
            unset($products_data_db[$key]);

            // دریافت مقدار موجودی انبار برای محصول از دیتابیس
            $inventory_query = "SELECT stock FROM products WHERE productqr = '$deleted_product'";
            $inventory_result = $connection->query($inventory_query);

            if($inventory_result->num_rows > 0) {
                $inventory_row = $inventory_result->fetch_assoc();
                $inventory_stock = $inventory_row['stock'];

                // دریافت مقدار موجودی قبل از حذف از دیتابیس
                $previous_quantity = $previous_quantities[$key];

                // بررسی موجودی انبار قبل از کسر مقدار
                if($inventory_stock >= $previous_quantity) {
                    // انجام عملیات کاهش موجودی
                    $update_inventory_sql = "UPDATE products SET stock = stock - $previous_quantity WHERE productqr = '$deleted_product'";
                    $connection->query($update_inventory_sql);
                } else {
                    // پیام به کاربر در صورت کمبود موجودی انبار
                    echo "موجودی انبار برای محصول $deleted_product کافی نیست و حذف محصول امکان پذیر نیست.<br>";
                }
            }
        }

        // بررسی تعداد محصولات ارسال شده از فرم و مقایسه با دیتابیس و کاهش موجودی محصولات
        foreach($products_form as $index => $product) {
            // بررسی آیا محصول در دیتابیس وجود دارد یا نه
            $inventory_query = "SELECT stock FROM products WHERE productqr = '$product'";
            $inventory_result = $connection->query($inventory_query);

            if($inventory_result->num_rows > 0) {
                // در صورت وجود محصول در دیتابیس
                $inventory_row = $inventory_result->fetch_assoc();
                $inventory_stock = $inventory_row['stock'];

                // دریافت مقدار موجودی قبل از ارسال فرم
                $previous_quantity = $previous_quantities[$index];

                // مقدار محصول ارسال شده از فرم
                $quantity_form = $quantities_form[$index];

                // بررسی موجودی انبار قبل از کسر مقدار
                if($inventory_stock >= $previous_quantity) {
                    // محاسبه تفاوت مقدار جدید با مقدار قبلی
                    $quantity_diff = $previous_quantity - $quantity_form;
                    // اگر مقدار جدید کمتر از مقدار قبلی بود
                    if($quantity_diff > 0) {
                        // انجام عملیات کاهش موجودی
                        $update_inventory_sql = "UPDATE products SET stock = stock - $quantity_diff WHERE productqr = '$product'";
                        $connection->query($update_inventory_sql);
                    } elseif($quantity_diff < 0) { // اگر مقدار جدید بیشتر از مقدار قبلی بود
                        // انجام عملیات افزایش موجودی
                        $update_inventory_sql = "UPDATE products SET stock = stock + " . abs($quantity_diff) . " WHERE productqr = '$product'";
                        $connection->query($update_inventory_sql);
                    }
                } else {
                    // پیام به کاربر در صورت کمبود موجودی انبار
                    echo "موجودی انبار برای محصول $product کافی نیست و بروزرسانی موجودی امکان پذیر نیست.<br>";
                }
            } else {
                // اگر محصول در دیتابیس وجود نداشته باشد
                echo "محصول $product در دیتابیس وجود ندارد و بنابراین امکان بروزرسانی موجودی انبار وجود ندارد.<br>";
            }
        }

        // آپدیت محتوای جدول products_input
        $products_data_json = json_encode($products_data_db);
        $update_products_input_sql = "UPDATE products_input SET product_data = '$products_data_json' WHERE entry_id = '$entry_id'";
        $connection->query($update_products_input_sql);

        // پیام در صورت موفقیت آمیز بودن به‌روزرسانی
        echo "<p>اطلاعات با موفقیت به‌روزرسانی شد.</p>";
    } else {
        echo "<p>هیچ محصولی وارد نشده است.</p>";
    }
    $message_sec = true;
}







// Check if id is set
if(isset($_GET['id'])) {
    $entry_id = $_GET['id'];
    
    // Retrieve products from the database
    $products_sql = "SELECT * FROM products";
    $products_result = $connection->query($products_sql);
    
    // استخراج اطلاعات محصولات ورودی از دیتابیس
    $product_input_sql = "SELECT * FROM products_input WHERE id = '$entry_id'";
    $product_input_result = $connection->query($product_input_sql);
    
    if($product_input_result->num_rows > 0) {
        $product_input_row = $product_input_result->fetch_assoc();
?>

<div class="main-content">
    <nav class="row">
        <?php  
        if(!empty($message_sec)){
        ?>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        محصولات با موفقیت ویرایش شدند
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="col-12 col-md-1 col-lg-1"></div>
        <div class="col-12 col-md-10 col-lg-10">
            <form method="post" id="productForm">
            <input type="hidden" name="entry_id" value="<?php echo $product_input_row['entry_id']; ?>">
                <div class="card">
                    <div class="card-header">
                        <h4><?php echo $title_page;?></h4>
                    </div>
                    <div class="card-body">
                        <div id="productsContainer">
                            <?php
                            // استخراج اطلاعات محصولات ورودی از دیتابیس
                            $products_input_sql = "SELECT * FROM products_input WHERE id = '$entry_id'";
                            $products_input_result = $connection->query($products_input_sql);
                            
                            if($products_input_result->num_rows > 0) {
                                $products_input_row = $products_input_result->fetch_assoc();
                                // تبدیل داده‌های JSON به آرایه
                                $products_data = json_decode($products_input_row['product_data'], true);
                                // تعداد محصولات ورودی
                                $product_count = count($products_data);
                                
                                if($product_count > 0) {
                                    foreach($products_data as $product) {
                                        ?>
                                        <div class="form-row productRow">
                                            <div class="form-group col-md-8">
                                                <label>نام محصول و یا بارکد</label>
                                                <select name="productName[]" class="form-control select2" required>
                                                    <?php
                                                    // نمایش گزینه‌های محصولات
                                                    foreach ($products_result as $product_row) {
                                                        $selected = ($product['productqr'] == $product_row['productqr']) ? 'selected' : '';
                                                        echo '<option value="' . $product_row['productqr'] . '" ' . $selected . '>' . $product_row['product_name'] . ' کد: ' . $product_row['productqr'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="productQuantity">تعداد</label>
                                                <input type="number" class="form-control productQuantity" name="productQuantity[]" value="<?php echo $product['quantity']; ?>" required>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <button type="button" class="btn btn-danger removeProduct">-</button>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo "<p>هیچ محصولی وارد نشده است.</p>";
                                }
                            } else {
                                echo "<p>هیچ محصولی وارد نشده است.</p>";
                            }
                            ?>
                        </div>
                        <div id="productControls">
                            <button type="button" class="btn btn-success addProduct"> افزودن محصول </button>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-4">
                                <label>تاریخ ورود:</label>
                                <input id="datepicker-check-in"  type="text" class="form-control" name="entry_date" value="<?php echo $product_input_row['date']; ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>ساعت:</label>
                                <input type="text" class="form-control" name="clock" value="<?php echo $product_input_row['clock']; ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>کاربر:</label>
                                <input type="text" class="form-control" name="user" value="<?php echo $product_input_row['user']; ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>نام فروشنده:</label>
                                <input type="text" class="form-control" name="foroshande_name" value="<?php echo $product_input_row['foroshande_name']; ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>شماره تماس فروشنده:</label>
                                <input type="number" class="form-control" name="foroshande_phone" value="<?php echo $product_input_row['foroshande_phone']; ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>نام راننده:</label>
                                <input type="text" class="form-control" name="name_ranande" value="<?php echo $product_input_row['name_ranande']; ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>شماره تماس راننده:</label>
                                <input type="number" class="form-control" name="phone_ranande" value="<?php echo $product_input_row['phone_ranande']; ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>شماره پلاک خودرو:</label>
                                <input type="text" class="form-control" name="pelak_khodro" value="<?php echo $product_input_row['pelak_khodro']; ?>" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label>توضیحات:</label>
                                <textarea name="comment" class="form-control"><?php echo $product_input_row['comment']; ?></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="update">به‌روزرسانی محصول</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-1 col-lg-1"></div>
    </nav>
</div>

<!-- jQuery library -->
<script src="<?php echo $base_url; ?>/assets/js/jquery-3.6.0.min.js"></script>

<!-- Custom script -->
<script>
$(document).ready(function() {
    // افزودن فیلد محصول با کلیک بر روی دکمه افزودن
    $(document).on('click', '.addProduct', function() {
        // ارسال درخواست AJAX به صفحه ajax.php
        $.ajax({
            url: 'ajax.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var products = response.products;
                    // افزودن داده‌های محصولات به تگ select
                    var options = '';
                    products.forEach(function(product) {
                        options += '<option value="' + product.productqr + '">' + product.product_name + ' کد: ' + product.productqr + '</option>';
                    });
                    // اضافه کردن فیلد محصول به فرم
                    var newRow = '<div class="form-row productRow">' +
                        '<div class="form-group col-md-8">' +
                        '<select name="productName[]" class="form-control select2" required>' +
                        '<option value="">انتخاب</option>' +
                        options +
                        '</select>' +
                        '</div>' +
                        '<div class="form-group col-md-3">' +
                        '<input type="number" class="form-control productQuantity" name="productQuantity[]" required>' +
                        '</div>' +
                        '<div class="form-group col-md-1">' +
                        '<button type="button" class="btn btn-danger removeProduct">-</button>' +
                        '</div>' +
                        '</div>';
                    $('#productsContainer').append(newRow);
                    
                    // اعمال Select2 بر روی المان select جدید
                    $('.select2').select2();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // حذف کردن فیلد محصول با کلیک بر روی دکمه حذف
    $(document).on('click', '.removeProduct', function() {
        $(this).closest('.productRow').remove();
    });
    
    // اعمال Select2 بر روی المان‌های موجود در صفحه
    $('.select2').select2();
});

</script>
<?php
    } else {
        echo "<p>محصول ورودی با این شناسه یافت نشد.</p>";
    }
} else {
    echo "<p>شناسه محصول ورودی مشخص نشده است.</p>";
}
require_once '../../../footer.php';
?>
