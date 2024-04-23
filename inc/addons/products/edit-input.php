<?php
$title_page = "ویرایش محصولات";
require_once '../../../header.php';

// Check if form is submitted
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


// Check if form ID is provided
if(isset($_GET['id'])) {
    $form_id = $_GET['id'];

    // Fetch form data from the database based on the form ID
    $form_sql = "SELECT * FROM products_input WHERE id = ?";
    $stmt = $connection->prepare($form_sql);
    $stmt->bind_param("i", $form_id);
    $stmt->execute();
    $form_result = $stmt->get_result();

    if($form_result->num_rows > 0) {
        $form_row = $form_result->fetch_assoc();

        // Extract form data
        $entry_date = $form_row['date'];
        $clock = $form_row['clock'];
        $entry_id = $form_row['entry_id'];
        $user_name = $form_row['user'];
        $foroshande_name = $form_row['foroshande_name'];
        $foroshande_phone = $form_row['foroshande_phone'];
        $ranande_name = $form_row['name_ranande'];
        $ranande_phone = $form_row['phone_ranande'];
        $ranande_pelak = $form_row['pelak_khodro'];
        $comment = $form_row['comment'];
        $product_data_json = $form_row['product_data'];

        // Decode product data JSON
        $product_data = json_decode($product_data_json, true);
    } else {
        // Handle error if form with provided ID is not found
        echo "فرم مورد نظر یافت نشد.";
        exit;
    }
} else {
    // Handle error if form ID is not provided
    echo "شناسه فرم مورد نظر ارسال نشده است.";
    exit;
}
// Retrieve products from the database
$products_sql = "SELECT * FROM products";
$products_result = $connection->query($products_sql);
?>

<div class="main-content">
    <nav class="row">
        <div class="col-12 col-md-1 col-lg-1"></div>
        <div class="col-12 col-md-10 col-lg-10">
            <nav class="form-row">
                <div class="card">
                    <div class="card-header">
                        <h6>شناسه کالا را وارد کنید</h6>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 form-group">
                            <input type="number" class="form-control productID" placeholder="شناسه محصول را وارد کنید">
                        </div>
                    </div>
                </div>
            </nav>

            <form method="post">
            <input type="hidden" name="entry_id" value="<?php echo $entry_id; ?>">
                <div class="card">
                    <div class="card-header">
                        <h4><?php echo $title_page;?></h4>
                    </div>
                    <div class="card-body">
                        <div id="productsContainer">
                            <!-- Existing products will be appended here -->
                            <?php
                            if(!empty($product_data)) {
                                foreach($product_data as $product) {
                                    echo '<div class="form-row productRow">' .
                                        '<div class="form-group col-md-8">' .
                                        '<input type="text" name="productqrrr[]" value="' . $product['productqr'] . '" hidden>' .
                                        '<input type="text" name="productName[]" class="form-control" required readonly value="' . $product['product_name'] . '">' .
                                        '</div>' .
                                        '<div class="form-group col-md-3">' .
                                        '<input type="number" class="form-control productQuantity text-center" name="productQuantity[]" value="' . $product['quantity'] . '" readonly required>' .
                                        '<button type="button" class="btn btn-sm btn-secondary decreaseQuantity">-</button>' .
                                        '</div>' .
                                        '<div class="form-group col-md-1">' .
                                        '<button type="button" class="btn btn-icon btn-danger removeProduct"><i class="fas fa-times"></i></button>' .
                                        '</div>' .
                                        '</div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>تاریخ ورود:</label>
                                <input id="datepicker-check-in" name="entry_date" class="form-control" required value="<?php echo $entry_date; ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>ساعت</label>
                                <input type="text" class="form-control" name="clock" value="<?php echo $clock; ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شناسه ورود</label>
                                <input type="text" class="form-control" name="id" value="<?php echo $entry_id; ?>" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>نام فروشنده</label>
                                <input type="text" class="form-control" name="foroshande_name" placeholder="نام فروشنده را وارد کنید" value="<?php echo $foroshande_name; ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شماره تماس فروشنده</label>
                                <input type="number" class="form-control" name="foroshande_phone" placeholder="شماره فروشنده را وارد کنید" value="<?php echo $foroshande_phone; ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>نام راننده</label>
                                <input type="text" class="form-control" name="ranande_name" placeholder="نام راننده را وارد کنید" value="<?php echo $ranande_name; ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شماره تماس راننده</label>
                                <input type="number" class="form-control" name="ranande_phone" placeholder="شماره تماس راننده را وارد کنید" value="<?php echo $ranande_phone; ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شماره پلاک خودرو</label>
                                <input type="text" class="form-control text-center" name="ranande_pelak" placeholder="شماره پلاک خودرو را وارد کنید" value="<?php echo $ranande_pelak; ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>کاربر ثبت کننده</label>
                                <input type="text" class="form-control text-center" name="user" placeholder=" نام ثبت کننده فرم " value="<?php echo $user_name; ?>">
                            </div>
                            <div class="form-group col-md-12">
                                <label>توضیحات</label>
                                <textarea name="comment" class="form-control"><?php echo $comment; ?></textarea>
                            </div>               
                        </div>
                        <input type="submit" class="btn btn-primary" name="update" id="insertButton" value=" بروزرسانی  "> 
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-1 col-lg-1"></div>
    </nav>
</div>

<!-- jQuery library -->
<script src="<?php echo $base_url; ?>/assets/js/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function() {
    // Function to handle product search and addition
    $('.productID').on('change', function() {
        var productID = $(this).val();
        $.ajax({
            url: 'search_product.php', // Replace with actual URL for product search
            method: 'POST',
            dataType: 'json',
            data: { productID: productID },
            success: function(response) {
                if (response.success) {
                    var product = response.product;
                    var existingProductRow = $('#productsContainer').find('input[value="' + product.productqr + '"]').closest('.productRow');
                    if(existingProductRow.length > 0) {
                        // If product already exists in the form, increase its quantity
                        var quantityInput = existingProductRow.find('.productQuantity');
                        var currentQuantity = parseInt(quantityInput.val());
                        var pack = parseInt(product.pack);
                        var newQuantity = currentQuantity + pack;
                        quantityInput.val(newQuantity);
                    } else {
                        // If product does not exist in the form, add it
                        var pack = parseInt(product.pack);
                        var initialQuantity = pack;
                        var newRow = '<div class="form-row productRow">' +
                            '<div class="form-group col-md-8">' +
                            '<input type="text" name="productqrrr[]" value="' + product.productqr + '" hidden>'+
                            '<input type="text" name="productName[]" class="form-control" required readonly  value="' + product.product_name + '">'+
                            '</div>' +
                            '<div class="form-group col-md-3">' +
                            '<input type="number" class="form-control productQuantity text-center" name="productQuantity[]" value="' + initialQuantity + '" readonly required>' +
                            '<button type="button" class="btn btn-sm btn-secondary decreaseQuantity">-</button>' +
                            '</div>' +
                            '<div class="form-group col-md-1">' +
                            '<button type="button" class="btn btn-icon btn-danger removeProduct"><i class="fas fa-times"></i></button>' +
                            '</div>' +
                            '</div>';
                        $('#productsContainer').append(newRow);
                    }
                    // Clear the product ID field
                    $('.productID').val('');
                    // Clear the search field
                    $('.productID').trigger('change.select2');
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Function to remove product from the form
    $(document).on('click', '.removeProduct', function() {
        $(this).closest('.productRow').remove();
    });

    // Function to decrease product quantity
    $(document).on('click', '.decreaseQuantity', function() {
        var quantityInput = $(this).siblings('.productQuantity');
        var newQuantity = parseInt(quantityInput.val()) - 1;
        if (newQuantity >= 0) {
            quantityInput.val(newQuantity);
        }
        // If quantity becomes zero, remove the product row
        if (newQuantity === 0) {
            $(this).closest('.productRow').remove();
        }
    });
});

</script>

<?php require_once '../../../footer.php'; ?>
 