<?php
$title_page = "ورود محصولات جدید";
require_once '../../../header.php';

// Check if the form is submitted
if(isset($_POST['insert'])) {
    // Initialize an empty array to store product data
    $products_data = array();

    // Iterate through each submitted product
    foreach($_POST['productName'] as $key => $product_name) {
        // Get product details from the database based on the product name or barcode
        $product_sql = "SELECT * FROM products WHERE productqr = '$product_name'";
        $product_result = $connection->query($product_sql);
        
        if($product_result->num_rows > 0) {
            $product_row = $product_result->fetch_assoc();
            
            // Construct product data array
            $product_data = array(
                'product_id' => $product_row['id'],
                'product_name' => $product_row['product_name'],
                'productqr' => $product_row['productqr'],
                'quantity' => $_POST['productQuantity'][$key]
            );

            // Add product data to the main array
            $products_data[] = $product_data;

            // Update product quantity in the products table
            $new_quantity = $product_row['stock'] + $_POST['productQuantity'][$key];
            $update_sql = "UPDATE products SET stock = $new_quantity WHERE id = " . $product_row['id'];
            $connection->query($update_sql);
        }
    }

    // Convert product data array to JSON format
    $json_data = json_encode($products_data);
    // Insert JSON data into the reports table
    $entry_date = $_POST['entryDate'];
    $clock = $_POST['clock'];
    $entry_id = $_POST['id'];
    $user_name=$_SESSION["username"];
    $foroshande_name=$_POST["foroshande_name"];//foroshande
    $foroshande_phone=$_POST["foroshande_phone"];
    $ranande_name=$_POST["ranande_name"];
    $ranande_phone=$_POST["ranande_phone"];
    $ranande_pelak=$_POST["ranande_pelak"];
    $comment=$_POST["comment"];
    $insert_sql = "INSERT INTO products_input (entry_id, date, clock, product_data,user,foroshande_name,foroshande_phone,name_ranande,phone_ranande,pelak_khodro,comment) VALUES ('$entry_id', '$entry_date', '$clock', '$json_data', '$user_name','$foroshande_name','$foroshande_phone','$ranande_name','$ranande_phone','$ranande_pelak','$comment')";
    $connection->query($insert_sql);

    // Show success message
    $message_sec="true";
}

// Retrieve products from the database
$products_sql = "SELECT * FROM products";
$products_result = $connection->query($products_sql);
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
                    محصولات با موفقیت وارد شدند
                </div>
            </div>
        </div>

        <?php } ?>
        <div class="col-12 col-md-1 col-lg-1"></div>
        <div class="col-12 col-md-10 col-lg-10">
            <form method="post" id="productForm">
                <div class="card">
                    <div class="card-header">
                        <h4><?php echo $title_page;?></h4>
                    </div>
                    <div class="card-body">
                        <div id="productsContainer">
                            <div class="form-row productRow">
                                <div class="form-group col-md-8">
                             
    <label>نام محصول و یا بارکد</label>
    <select  name="productName[]" class="form-control select2" required>
        <option value="">انتخاب</option>
        <?php
        if ($products_result->num_rows > 0) {
            while ($products_row = $products_result->fetch_assoc()) {
                echo '<option value="' . $products_row['productqr'] . '">' . $products_row['product_name'] .' کد: '.$products_row['productqr'] . '</option>';
            }
        } else {
            echo "<option value=''>نتیجه‌ای یافت نشد</option>";
        }
        ?>
    </select>
        </div>
                                <div class="form-group col-md-3">
                                    <label for="productQuantity">تعداد</label>
                                    
                                    <input type="number" class="form-control productQuantity" name="productQuantity[]" required>
                                </div>
                                <div class="form-group col-md-1">
                                    <button type="button" class="btn btn-danger removeProduct">-</button>
                                </div>
                            </div>
                        </div>
                        <div id="productControls">
                            <button type="button" class="btn btn-success addProduct"> افزودن محصول </button>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>تاریخ ورود:</label>
                                <input id="datepicker-check-in" name="entryDate" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>ساعت</label>
                                <input type="text" class="form-control" name="clock" value="<?php echo jdate("H:i"); ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شناسه ورود</label>
                                <input type="text" class="form-control" name="id" value="<?php echo rand(100,999999999999999999); ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>نام فروشنده</label>
                                <input type="text" class="form-control" name="foroshande_name" placeholder="نام فروشنده را وارد کنید">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شماره تماس فروشنده</label>
                                <input type="number" class="form-control" name="foroshande_phone" placeholder="شماره فروشنده را وارد کنید">
                            </div>
                            <div class="form-group col-md-4">
                                <label>نام راننده</label>
                                <input type="text" class="form-control" name="ranande_name" placeholder="نام راننده را وارد کنید">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شماره تماس راننده</label>
                                <input type="number" class="form-control" name="ranande_phone" placeholder="شماره تماس راننده را وارد کنید">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شماره پلاک خودرو</label>
                                <input type="text" class="form-control" name="ranande_pelak" placeholder="شماره پلاک خودرو را وارد کنید">
                            </div>
                            <div class="form-group col-md-12">
                                <label>توضیحات</label>
                             
                                <textarea name="comment" class="form-control"></textarea>
                            </div>               
                        </div>
                       
                        <button type="submit" class="btn btn-primary" name="insert">ورود محصول به انبار</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-1 col-lg-1"></div>
    </nav>
</div>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
<?php require_once '../../../footer.php'; ?>
