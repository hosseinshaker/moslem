<?php
$title_page = "خروج محصول از انبار";
require_once '../../../header.php';

// Check if the form is submitted
if(isset($_POST['exit'])) {
    // Initialize an empty array to store product data
    $products_data = array();

    // Flag to track if any product has insufficient stock
    $insufficient_stock = false;



    // Check if all requested quantities are available in stock
    foreach($_POST['productName'] as $key => $product_name) {
        // Get product details from the database based on the product name or barcode
        $product_sql = "SELECT * FROM products WHERE productqr = '$product_name'";
        $product_result = $connection->query($product_sql);
        
        if($product_result->num_rows > 0) {
            $product_row = $product_result->fetch_assoc();
            
            // Check if requested quantity is available
            $requested_quantity = $_POST['productQuantity'][$key];
            $current_quantity = $product_row['stock'];

            if($requested_quantity > $current_quantity) {
                // Set flag to true if any product has insufficient stock
                $insufficient_stock = true;
                break; // Exit the loop if any product has insufficient stock
            }
        }
    }

    // If all requested quantities are available, proceed with the exit process
    if (!$insufficient_stock) {
        // Deduct quantities from the inventory and update product quantities
        foreach($_POST['productName'] as $key => $product_name) {
            // Get product details from the database based on the product name or barcode
            $product_sql = "SELECT * FROM products WHERE productqr = '$product_name'";
            $product_result = $connection->query($product_sql);
            
            if($product_result->num_rows > 0) {
                $product_row = $product_result->fetch_assoc();
                
                // Get requested quantity
                $requested_quantity = $_POST['productQuantity'][$key];

                // Update product quantity in the products table
                $new_quantity = $product_row['stock'] - $requested_quantity;
                $update_sql = "UPDATE products SET stock = $new_quantity WHERE id = " . $product_row['id'];
                $connection->query($update_sql);
                // Construct product data array
                $product_data = array(
                    'product_id' => $product_row['id'],
                    'product_name' => $product_row['product_name'],
                    'productqr' => $product_row['productqr'],
                    'quantity' => $requested_quantity
                );
                // Add product data to the main array
                $products_data[] = $product_data;
            }
        }
        // Convert product data array to JSON format
        $json_data = json_encode($products_data, JSON_UNESCAPED_UNICODE);        // Insert JSON data into the exit reports table
        $exit_date = $_POST['exitDate'];
        $clock = $_POST['clock'];
        $exit_id = $_POST['id'];
        $user_name=$_SESSION["username"];
        $kharidar_name=$_POST["kharidar_name"];
        $kharidar_phone=$_POST["kharidar_phone"];
        $ranande_name=$_POST["ranande_name"];
        $ranande_phone=$_POST["ranande_phone"];
        $ranande_pelak=$_POST["ranande_pelak"];
        $bargekhoroj=$_POST["bargekhoroj"];
        $comment=$_POST["comment"];
        $insert_sql = "INSERT INTO products_output (exit_id, date, clock, product_data,user,kharidar_name,kharidar_phone,name_ranande,phone_ranande,pelak_khodro,shomareh_bargkhoroj,comment) VALUES ('$exit_id', '$exit_date', '$clock', '$json_data', '$user_name','$kharidar_name','$kharidar_phone','$ranande_name','$ranande_phone','$ranande_pelak','$bargekhoroj','$comment')";
        $connection->query($insert_sql);

        // Show success message
        $message_sec = true;
    } else {
        // Show error message for insufficient stock
        $error_message = "مقدار خواسته شده برای یک یا چند محصول بیشتر از مقدار موجود در انبار است.";
    }
}

// Retrieve products from the database
$products_sql = "SELECT * FROM products";
$products_result = $connection->query($products_sql);
?>


<div class="main-content">
    <nav class="row">
        <?php if(!empty($message_sec)) { ?>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        محصولات با موفقیت از انبار خارج شدند
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if(isset($error_message)) { ?>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        <?php echo $error_message; ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="col-12 col-md-1 col-lg-1"></div>
        <div class="col-12 col-md-10 col-lg-10">
            <form method="post" id="exitForm">
                <div class="card">
                    <div class="card-header">
                        <h4><?php echo $title_page;?></h4>
                    </div>
                    <div class="card-body">
                        <div id="productsContainer">
                            <div class="form-row productRow">
                                <div class="form-group col-md-8">
                                    <label>نام محصول و یا بارکد</label>
                                    <select name="productName[]" class="form-control select2" required>
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
                                <label>تاریخ خروج:</label>
                                <input id="datepicker-check-out" name="exitDate" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>ساعت خروج</label>
                                <input type="text" class="form-control" name="clock" value="<?php echo jdate("H:i"); ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شناسه خروج</label>
                                <input type="text" class="form-control" name="id" value="<?php echo rand(100,999999999999999999); ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>نام خریدار</label>
                                <input type="text" class="form-control" name="kharidar_name" placeholder="نام خریدار را وارد کنید">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شماره تماس خریدار</label>
                                <input type="number" class="form-control" name="kharidar_phone" placeholder="شماره خریدار را وارد کنید">
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
                            <div class="form-group col-md-4">
                                <label>شماره برگه خروج</label>
                                <input type="number" class="form-control" name="bargekhoroj" placeholder="شماره برگه خروج را وارد کنید">
                            </div>
                            <div class="form-group col-md-12">
                                <label>توضیحات</label>
                             
                                <textarea name="comment" class="form-control"></textarea>
                            </div>               

                        </div>
                        <button type="submit" class="btn btn-primary" name="exit">خروج محصولات از انبار</button>
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
    // Add product field with click on add button
    $(document).on('click', '.addProduct', function() {
        // Send AJAX request to ajax.php
        $.ajax({
            url: 'ajax.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var products = response.products;
                    // Add products data to select tag
                    var options = '';
                    products.forEach(function(product) {
                        options += '<option value="' + product.productqr + '">' + product.product_name + ' کد: ' + product.productqr + '</option>';
                    });
                    // Add product field to the form
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
                    
                    // Apply Select2 on the new select element
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

    // Remove product field with click on remove button
    $(document).on('click', '.removeProduct', function() {
        $(this).closest('.productRow').remove();
    });
    
    // Apply Select2 on existing elements in the page
    $('.select2').select2();
});


document.addEventListener("DOMContentLoaded", function() {
        var searchInput = document.getElementById("searchInput");
        searchInput.focus();
    });
</script>
<?php require_once '../../../footer.php'; ?>
