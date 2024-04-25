<?php
$title_page = "خروج محصولات از انبار";
require_once '../../../header.php';

// Check if the form is submitted
if(isset($_POST['exit'])) {
    // Initialize an empty array to store product data
    $products_data = array();

    // Check if all products have sufficient quantity in stock
    $all_products_available = true;
    foreach ($_POST['productqrrr'] as $key => $product_name) {
        $required_quantity = $_POST['productQuantity'][$key];
        $product_sql = "SELECT stock FROM products WHERE productqr = '$product_name'";
        $product_result = $connection->query($product_sql);
        if ($product_result->num_rows > 0) {
            $product_row = $product_result->fetch_assoc();
            $available_quantity = $product_row['stock'];
            if ($required_quantity > $available_quantity) {
                // Product quantity in stock is less than required quantity
                $all_products_available = false;
                // Notify the user about insufficient stock
                $insufficient_product_name = $product_name; // You can use this variable to display the product name in the notification message
                break; // Exit the loop early since at least one product is not available in sufficient quantity
            }
        }
    }

    if ($all_products_available) {
        // Proceed with reducing product quantity in stock and inserting the report
        // Iterate through each submitted product
        foreach ($_POST['productqrrr'] as $key => $product_name) {
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
                $new_quantity = $product_row['stock'] - $_POST['productQuantity'][$key];
                $update_sql = "UPDATE products SET stock = $new_quantity WHERE id = " . $product_row['id'];
                $connection->query($update_sql);
            }
        }

        // Convert product data array to JSON format
        $json_data = json_encode($products_data, JSON_UNESCAPED_UNICODE);

        // Insert JSON data into the reports table
        $entry_date = $_POST['entryDate'];
        $clock = $_POST['clock'];
        $exit_id = $_POST['exit_id'];
        $user_name=$_SESSION["username"];
        $kharidar_name=$_POST["kharidar_name"];//kharidar
        $kharidar_phone=$_POST["kharidar_phone"];
        $ranande_name=$_POST["ranande_name"];
        $ranande_phone=$_POST["ranande_phone"];
        $ranande_pelak=$_POST["ranande_pelak"];
        $bargkhoroj=$_POST["bargkhoroj"];
        $comment=$_POST["comment"];
        $insert_sql = "INSERT INTO products_output (exit_id, date, clock, product_data,user,user_edited,comment,name_ranande,phone_ranande,pelak_khodro,kharidar_name,kharidar_phone,shomareh_bargkhoroj) VALUES ('$exit_id', '$entry_date', '$clock', '$json_data', '$user_name','$user_name','$comment','$ranande_name','$ranande_phone','$ranande_pelak','$kharidar_name','$kharidar_phone','$bargkhoroj')";
        $connection->query($insert_sql);

        // Show success message
        $message_sec="true";
    } else {
        // Notify the user about insufficient stock
        $mess_err= "موجودی محصول با شناسه $insufficient_product_name کافی نیست.";
    }
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
                    محصولات با موفقیت از انبار خارج شدند
                </div>
            </div>
        </div>

        <?php } ?>
        <?php  
if(!empty($mess_err)){
?>
        <div class="col-12 col-md-12 col-lg-12">
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    <?php echo $mess_err; ?>
                </div>
            </div>
        </div>

        <?php } ?>
        <div class="col-12 col-md-1 col-lg-1"></div>
        <div class="col-12 col-md-10 col-lg-10">
            <nav class="form-row">
                <div class="card">
                    <div class="card-header">
                        <h6>شناسه کالا را وارد کنید</h6>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 form-group">
                            <input type="number" class="form-control productID" placeholder="شناسه محصول را وارد کنید" id="searchInput">
                        </div>
                    </div>
                </div>
            </nav>

            <form method="post">
                <div class="card">
                    <div class="card-header">
                        <h4><?php echo $title_page;?></h4>
                    </div>
                    <div class="card-body">
                        <div id="productsContainer">
                            <!-- Existing products will be appended here -->
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>تاریخ خروج:</label>
                                <input id="datepicker-check-in" name="entryDate" class="form-control" required value="<?php echo jdate("Y/m/d",'','','','en'); ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>ساعت</label>
                                <input type="text" class="form-control" name="clock" value="<?php echo jdate("H:i",'','','','en'); ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شناسه خروج</label>
                                <input type="text" class="form-control" name="exit_id" value="<?php echo jdate("Ymd",'','','','en'); ?><?php echo rand(1,9999999); ?>">
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
                                <input type="text" class="form-control" name="ranande_name" placeholder="نام راننده را وارد کنید" value="علی کشاورز">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شماره تماس راننده</label>
                                <input type="number" class="form-control" name="ranande_phone" placeholder="شماره تماس راننده را وارد کنید" value="09171393541">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شماره پلاک خودرو</label>
                                <input type="text" class="form-control text-center" name="ranande_pelak" placeholder="شماره پلاک خودرو را وارد کنید" value="77ل222 ایران 93">
                            </div>
                            <div class="form-group col-md-4">
                                <label> شماره برگه خروج </label>
                                <input type="text" class="form-control text-center" name="bargkhoroj" placeholder="شماره برگه خروج را وارد کنید">
                            </div>
                            <div class="form-group col-md-12">
                                <label>توضیحات</label>
                                <textarea name="comment" class="form-control"></textarea>
                            </div>               
                        </div>
                        <input type="submit" class="btn btn-primary" name="exit" id="exitButton" value="خروج محصولات از انبار"> 
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

document.addEventListener("DOMContentLoaded", function() {
        var searchInput = document.getElementById("searchInput");
        searchInput.focus();
    });
</script>

<?php require_once '../../../footer.php'; ?>
