<?php
$title_page = "ورود محصولات جدید";
require_once '../../../header.php';
// اگر فرم ارسال شده است
if(isset($_POST['insert'])) {
    // دریافت مقادیر ارسال شده از فرم
    $entryDate = $_POST['entryDate'];
    $clock = $_POST['clock'];
    $id = $_POST['id'];
    $productNames = $_POST['productName'];
    $productQuantities = $_POST['productQuantity'];

    // آرایه‌ای برای ذخیره نام و بارکد محصولات 
    $productsArray = [];

    // ثبت محصولات و تعداد آن‌ها در جدول گزارشات و ساخت آرایه نام و بارکد
    foreach($productNames as $key => $productName) {
        $quantity = $productQuantities[$key];
        $report_query = "INSERT INTO reports (entry_date, clock, id, product_name, quantity) VALUES ('$entryDate', '$clock', '$id', '$productName', '$quantity')";
        $connection->query($report_query);
        
        // اضافه کردن نام و بارکد به آرایه
        $productsArray[] = ['name' => $productName, 'barcode' => $productQuantities[$key]];
    }

    // تبدیل آرایه به JSON
    $productsJSON = json_encode($productsArray);

    // ذخیره JSON در دیتابیس
    $save_query = "INSERT INTO products_array (products) VALUES ('$productsJSON')";
    $connection->query($save_query);
}

// products
$products_sql = "SELECT * FROM products";
$products_result = $connection->query($products_sql);
?>

<div class="main-content">
    <nav class="row">
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