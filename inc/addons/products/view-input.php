<?php
$title_page = "جزئیات محصولات ورودی";
require_once '../../../header.php';

// دریافت شناسه محصول ورودی
if(isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // دریافت اطلاعات محصول ورودی از دیتابیس
    $product_input_sql = "SELECT * FROM products_input WHERE id = $product_id";
    $product_input_result = $connection->query($product_input_sql);
    
    if ($product_input_result->num_rows > 0) {
        $product_input_row = $product_input_result->fetch_assoc();
        // نمایش جدول محصولات ورودی
        $product_data = json_decode($product_input_row['product_data'], true);
        if($product_data && is_array($product_data)) {
            ?>
<div class="main-content">
    <nav class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>لیست محصولات ورودی</h4>
                </div>
                <div class="card-body">
                <div id="printContent">
 
            <?php
        // نمایش شناسه ورود
        echo "<div class='form-row'>";
        echo "<div class='form-group col-md-3'><label>شناسه ورود: ". $product_input_row['entry_id'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label> نام فروشنده: ". $product_input_row['foroshande_name'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label> شماره تماس فروشنده: ". $product_input_row['foroshande_phone'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label> نام راننده: ". $product_input_row['name_ranande'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label> شماره تماس راننده: ". $product_input_row['phone_ranande'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label> پلاک خودرو : ". $product_input_row['pelak_khodro'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label>تاریخ : ". $product_input_row['date'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label>ساعت : ". $product_input_row['clock'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label>کاربر ثبت کننده : ". $product_input_row['user'] ."</label></div>";
        echo "<div class='form-group col-md-7'><label>توضیحات : ". $product_input_row['comment'] ."</label></div>";
        if(!empty($product_input_row['user_edited'])){
            echo "<div class='form-group col-md-2'><label> ویرایش شده توسط: ". $product_input_row['user_edited'] ."</label></div>";
        }

       
       
       
        echo "</div>";
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped table-hover" id="tableExport" style="width:100%;text-align:center;">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ردیف</th>';
            echo '<th>بارکد محصول</th>';
            echo '<th>نام محصول</th>';
            echo '<th>تعداد</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            $index = 1;
            foreach ($product_data as $product) {
                echo '<tr>';
                echo '<td>' . $index . '</td>';
                echo '<td>' . $product['productqr'] . '</td>';
                echo '<td>' . $product['product_name'] . '</td>';
                echo '<td>' . $product['quantity'] . '</td>';
                echo '</tr>';
                $index++;
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            ?>
            <button class="btn btn-info" id="printButton">پرینت</button>

                </div>
            </div>
            </div>
        </div>
    </nav>
</div>

<?php
        } else {
            echo "<p>اطلاعات محصولات وارد شده در دسترس نیست.</p>";
        }
    } else {
        echo "<p>محصول ورودی با این شناسه یافت نشد.</p>";
    }
} else {
    echo "<p>شناسه محصول ورودی مشخص نشده است.</p>";
}
?>
<script>
document.getElementById("printButton").addEventListener("click", function() {
    var printContent = document.getElementById("printContent").innerHTML;
    var originalContent = document.body.innerHTML; // ذخیره محتوای اصلی صفحه
    
    // تغییر محتوای صفحه به محتوای تگ مورد نظر برای پرینت
    document.body.innerHTML = printContent;

    window.print(); // پرینت کردن محتوای تغییر یافته
    
    // بازگرداندن محتوای اصلی صفحه
    document.body.innerHTML = originalContent;
});
</script>
<?php
require_once '../../../footer.php';
?>
