<?php
$title_page="افزودن محصول اولیه جدید";
require_once '../../../header.php';



// colors
$color_sql = "SELECT * FROM colors";
$color_result = $connection->query($color_sql);

// materials
$materials_sql = "SELECT * FROM materials";
$materials_result = $connection->query($materials_sql);
// پارامترهای محصول اولیه
if(isset($_POST['insert'])){

    // جدید: دریافت طرح و رنگ
    $productPattern = $_POST['productPattern'] ?? ''; // اگر وجود نداشته باشد، مقدار پیش‌فرض خالی
    $productColor = $_POST['productColor'] ?? ''; // اگر وجود نداشته باشد، مقدار پیش‌فرض خالی
$product_name=$_POST['product_name'];//نام محصول اولیه
$productCount=$_POST['productCount'];//مقدار محصول
$productType=$_POST['productType'];//محصول از چه نوع است؟
$entryDate = $_POST['entryDate'];//تاریخ ورود به انبار
$minStock = $_POST['minStock'];//حداقل موجودی برای اخطار افزایش محصول
    // تغییر دستور INSERT
    $sql = "INSERT INTO primaryproduct (product_name, productCount, productType, entryDate, minStock,  productPattern, productColor) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssssss", $product_name, $productCount, $productType, $entryDate, $minStock, $productPattern, $productColor);

if ($stmt->execute() === TRUE) {
  $message_data= "True";
} else {
    echo "خطا در ثبت محصول اولیه: " . $connection->error;
}
$connection->close();
}
?>
<div class="main-content">
<nav class="row">
<?php
if(!empty($message_data)&&  $message_data= "True"):
?>
<nav class="col-12 col-md-12 col-lg-12">
<div class="alert alert-success alert-dismissible show fade">
                      <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                          <span>×</span>
                        </button>
محصول اولیه با موفقیت ثبت شد
                    </div>
                    </div>
</nav>
<?php
endif;
?>
<div class="col-12 col-md-3 col-lg-3"></div>
<div class="col-12 col-md-6 col-lg-6">

            <form method="post">
                            <div class="card">
                                <div class="card-header">
                                    <h4>افزودن محصول اولیه جدید</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>نام محصول اولیه</label>
                                        <input type="text" class="form-control" name="product_name"required>
                                    </div>
                                    <div class="form-group " style="display: none;">
                                        <label>تعداد محصول اولیه</label>
                                        <input type="number" class="form-control" name="productCount" hidden value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>واحد</label>
                                        <select class="form-control" required name="productType">
                                            <option value="انتخاب نشده" selected>انتخاب کنید</option>
                                            <option value="عدد">عدد</option>
                                            <option value="گرم">گرم</option>
                                            <option value="کیلوگرم">کیلوگرم</option>
                                            <option value="سانتی متر">سانتی متر</option>
                                            <option value="متر">متر</option>
                                        </select>
                                    </div>
               
<div class="form-group">
    <label>انتخاب طرح محصول</label>
    <select name="productPattern" class="form-control select2" required>
        <option value="">انتخاب*</option>
        <?php
        if ($materials_result->num_rows > 0) {
            while ($materials_row = $materials_result->fetch_assoc()) {
                echo '<option value="' . $materials_row['material_name'] . '">' . $materials_row['material_name'] . '</option>';
            }
        } else {
            echo "<option value=''>نتیجه‌ای یافت نشد</option>";
        }
        ?>
    </select>
     </div>


     <div class="form-group">
     <label>انتخاب رنگ محصول</label>
    <select name="productColor" class="form-control select2" required>
        <option value="">انتخاب*</option>
        <?php
        if ($color_result->num_rows > 0) {
            while ($color_row = $color_result->fetch_assoc()) {
                echo '<option value="' . $color_row['colorname'] . '">' . $color_row['colorname'] . '</option>';
            }
        } else {
            echo "<option value=''>نتیجه‌ای یافت نشد</option>";
        }
        ?>
    </select>
     </div>

                                    <div class="form-group">
                                        <label>تاریخ ورود:</label>
                                        <input  id="datepicker-check-in" name="entryDate" class="form-control"required>
                                    </div>
                                    <div class="form-group">
                                        <label>حداقل موجودی برای اخطار اتمامی محصول اولیه</label>
                                        <input type="number" class="form-control" name="minStock" required>
                                    </div>
                                    <button class="btn btn-primary" name="insert">افزودن</button>
                                </div>
                            </div>
             </form>
</div>
<div class="col-12 col-md-3 col-lg-3"></div>
</nav>
</div>
</div>
<?php require_once '../../../footer.php';?>