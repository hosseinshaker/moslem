<?php
$title_page = "ورود محصولات جدید";
require_once '../../../header.php';

// Check if the form is submitted
if(isset($_POST['insert'])) {
    // Initialize an empty array to store product data
    $products_data = array();

    // Iterate through each submitted product
    foreach($_POST['productqrrr'] as $key => $product_name) {
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
    $json_data = json_encode($products_data, JSON_UNESCAPED_UNICODE);

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
                                <label>تاریخ ورود:</label>
                                <input id="datepicker-check-in" name="entryDate" class="form-control" required value="<?php echo jdate("Y/m/d",'','','','en'); ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>ساعت</label>
                                <input type="text" class="form-control" name="clock" value="<?php echo jdate("H:i",'','','','en'); ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شناسه ورود</label>
                                <input type="text" class="form-control" name="id" value="<?php echo jdate("Ymd",'','','','en'); ?><?php echo rand(1,9999999); ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>نام فروشنده</label>
                                <input type="text" class="form-control" name="foroshande_name" placeholder="نام فروشنده را وارد کنید" value="گروه تولیدی مسلم">
                            </div>
                            <div class="form-group col-md-4">
                                <label>شماره تماس فروشنده</label>
                                <input type="number" class="form-control" name="foroshande_phone" placeholder="شماره فروشنده را وارد کنید" value="09038483002">
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
                            <div class="form-group col-md-12">
                                <label>توضیحات</label>
                                <textarea name="comment" class="form-control"></textarea>
                            </div>               
                        </div>
                        <input type="submit" class="btn btn-primary" name="insert" id="insertButton" value="ورود محصولات به انبار"> 
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

    document.addEventListener("DOMContentLoaded", function() {
    var noPasteInput = document.getElementById('searchInput');
    
    // ممنوع کردن کپی کردن محتویات
    noPasteInput.addEventListener('copy', function(e) {
        e.preventDefault();
    });
    
    // ممنوع کردن جایگذاری محتویات
    noPasteInput.addEventListener('paste', function(e) {
        e.preventDefault();
    });
});
</script>

<?php require_once '../../../footer.php'; ?>
