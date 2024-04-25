<?php
$title_page = "جزئیات محصولات خروجی";
require_once '../../../header.php';

// دریافت شناسه محصول خروجی
if(isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // دریافت اطلاعات محصول خروجی از دیتابیس
    $product_output_sql = "SELECT * FROM products_output WHERE id = $product_id";
    $product_output_result = $connection->query($product_output_sql);
    
    if ($product_output_result->num_rows > 0) {
        $product_output_row = $product_output_result->fetch_assoc();
        // نمایش جدول محصولات خروجی
        $product_data = json_decode($product_output_row['product_data'], true);
        if($product_data && is_array($product_data)) {
            ?>
<div class="main-content">
    <nav class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>لیست محصولات خروجی</h4>
                </div>
                <div class="card-body">
                <div id="printContent">
 
            <?php
        // نمایش شناسه خروج
        echo "<div class='form-row'>";
        echo "<div class='form-group col-md-3'><label>شناسه خروج: ". $product_output_row['exit_id'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label> نام خریدار: ". $product_output_row['kharidar_name'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label> شماره تماس خریدار: ". $product_output_row['kharidar_phone'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label> نام راننده: ". $product_output_row['name_ranande'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label> شماره تماس راننده: ". $product_output_row['phone_ranande'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label> پلاک خودرو : ". $product_output_row['pelak_khodro'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label>تاریخ : ". $product_output_row['date'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label>ساعت : ". $product_output_row['clock'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label>کاربر ثبت کننده : ". $product_output_row['user'] ."</label></div>";
        echo "<div class='form-group col-md-3'><label>شماره برگه خروج: ". $product_output_row['shomareh_bargkhoroj'] ."</label></div>";
        echo "<div class='form-group col-md-7'><label>توضیحات : ". $product_output_row['comment'] ."</label></div>";
        if(!empty($product_output_row['user_edited'])){
            echo "<div class='form-group col-md-2'><label> ویرایش شده توسط: ". $product_output_row['user_edited'] ."</label></div>";
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
            echo "<p>اطلاعات محصولات خروجی در دسترس نیست.</p>";
        }
    } else {
        echo "<p>محصول خروجی با این شناسه یافت نشد.</p>";
    }
} else {
    echo "<p>شناسه محصول خروجی مشخص نشده است.</p>";
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
