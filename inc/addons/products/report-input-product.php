<?php
$title_page = "گزارش ورودی محصولات";
require_once '../../../header.php';

// اگر فرم ارسال شده باشد
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send'])) {
    // اطلاعات فرم ارسالی را دریافت کنید
    $productName = isset($_POST['productName']) ? $_POST['productName'] : array(); // افزودن شرط برای مقدار پیش‌فرض
    $date_in = $_POST['date_in'];
    $date_out = $_POST['date_out'];

    // ساخت کوئری برای جستجو در جدول products_input
    $query = "SELECT * FROM products_input WHERE 1=1";

    // اضافه کردن شرط تاریخ ورود اگر مقدار ارسال شده غیر خالی باشد
    if (!empty($date_in)) {
        $query .= " AND date >= '" . $date_in . "'";
    }

    // اضافه کردن شرط تاریخ خروج اگر مقدار ارسال شده غیر خالی باشد
    if (!empty($date_out)) {
        $query .= " AND date <= '" . $date_out . "'";
    }

    // اجرای کوئری
    $result = $connection->query($query);

    // نمایش جدول اگر رکوردی یافت شود
    if ($result->num_rows > 0) {
?>
<div class="main-content">
     <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>نمایش گزارش</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-center">
                      
                            <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>تاریخ</th>
                                        <th>شناسه ورود</th>
                                        <th>نام محصول</th>
                                        <th>تعداد</th>
                                     
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    
                                // محاسبه جمع محصولات
        $total_products = 0;
                                    
        while ($row = $result->fetch_assoc()) {
            // واکشی اطلاعات محصول از جدول products_input با استفاده از JSON
            $product_data = json_decode($row['product_data'], true);

            foreach ($product_data as $product) {
                // اگر شناسه محصول ارسال شده بود و مطابق با آن بود، نمایش کن
                if ((!empty($productName) && in_array($product['productqr'], $productName)) || empty($productName)) {
                                    ?>
                                        <tr>
                                           
                                            <td><?php echo  $row['date'];  ?></td>
                                            <td><?php echo  $row['entry_id'];  ?></td>
                                            <td><?php echo  $product['product_name'];  ?></td>
                                            <td><?php echo  $product['quantity'];  ?></td>
                                        </tr>
                                    <?php   
                                    $total_products += $product['quantity'];             
            }
            }
        }
        ?>
        <?php  echo "<tr><td>جمع کل محصولات: </td><td></td><td></td><td>" . $total_products . "</td></tr>";  ?>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
        </div>


<?php
    } else {
        // اگر رکوردی یافت نشود
        echo "نتیجه‌ای یافت نشد";
    }
}

require_once '../../../footer.php';
?>
