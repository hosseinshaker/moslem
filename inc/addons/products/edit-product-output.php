<?php
$title_page = "ویرایش خروج محصول از انبار";
require_once '../../../header.php';
// دریافت اطلاعات از جدول users


if (isset($_GET['update'])){
    $update_id = $_GET['update'];
    // دریافت اطلاعات از جدول productoutputreport
    $output_sql = "SELECT * FROM product_outputs WHERE id = $update_id";
    $output_result = $connection->query($output_sql);
    $output_row = $output_result->fetch_assoc();
    var_dump($output_row);
    // اطلاعات محصول
    $product_id = $output_row['product_id'];
    // تغییر کوئری برای دریافت نام محصول بر اساس شناسه
    $product_sql = "SELECT product_name FROM products WHERE id = ?";
    $stmt = $connection->prepare($product_sql);
    $stmt->bind_param("i", $product_id); // "i" به معنی integer است
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product_row = $result->fetch_assoc();
        $product_name = $product_row['product_name'];
    } 
    $user_sql = "SELECT * FROM users";
    $user_result = $connection->query($user_sql);
    $user_id = $output_row['username'];
    // تغییر کوئری برای دریافت نام کاربر بر اساس شناسه
    $user_sql = "SELECT username FROM users WHERE id = ?";
    $stmt = $connection->prepare($user_sql);
    $stmt->bind_param("i", $user_id); // "i" به معنی integer است
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user_row = $result->fetch_assoc();
        $user_name = $user_row['username'];
    } 
// colors
$color_sql = "SELECT * FROM colors";
$color_result = $connection->query($color_sql);
// materials
$materials_sql = "SELECT * FROM materials";
$materials_result = $connection->query($materials_sql);
?>
<div class="main-content">
    <nav class="row">
<nav class="col-12 col-md-12 col-lg-12">
    error mesage
</nav>
        <div class="col-12 col-md-3 col-lg-1"></div>
        <div class="col-12 col-md-6 col-lg-10">
        <form method="post" action="process-edit-outpout.php">
                <div class="card">
                    <div class="card-header">
                        <h4>خروج محصول از انبار</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>تاریخ خروج از انبار</label>
                            <input  id="datepicker-check-in" name="date_output" class="form-control" value="<?php  echo $output_row['date_output']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>نام محصول  </label>
                            <div id="materialContainer">
                                <div class="materialGroup">
                                    <select name="product_name" class="form-control " required>
                                        <?php
                                   echo '<option value="' . $output_row['id'] . '">' . $product_name  . '</option>';
                                        ?>
                                    </select>
                                    <div class="form-group">
                                        <label>تعداد محصول</label>
                                        <input type="number" class="form-control" placeholder="مقدار"  value="<?php  echo $output_row['quantity']; ?>" name="quantity" required>
                                    </div>
                                    <div class="form-group">
                                        <label> مواد های اولیه</label>
                                        </div>
<?php
$materials_json = $output_row['materials'];
$materials_array = json_decode($materials_json, true);

foreach ($materials_array as $material_id => $quantity) {
    // دریافت نام محصول بر اساس شناسه
    $material_sql = "SELECT product_name,id FROM primaryproduct WHERE id = ?";
    $stmt = $connection->prepare($material_sql);
    $stmt->bind_param("i", $material_id);
    $stmt->execute();
    $material_result = $stmt->get_result();

    if ($material_result->num_rows > 0) {
        $material_row = $material_result->fetch_assoc();
        $material_name = $material_row['product_name'];
        $material_id = $material_row['id'];
echo '
<div class="form-group">
<label>' . $material_name .' </label>
<input name="materials['.$material_id.']" class="form-control" value="'.$quantity.'" required>
<input type="hidden" name="materials_old['.$material_id.']" class="form-control" value="'.$quantity.'">
</div>';
    } else {
        echo "محصولی با شناسه " . $material_id . " یافت نشد.<br>";
    }
}
?>

                                    <div class="form-group">
    <label>انتخاب طرح محصول</label>
    <select name="product_pattern" class="form-control select2" required>
        <?php
             echo '<option value="' . $output_row['product_pattern'] . '">' . $output_row['product_pattern'] . '</option>';
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
    <select name="product_color" class="form-control select2" required>
        <?php
                        echo '<option value="' . $output_row['product_color'] . '">' . $output_row['product_color'] . '</option>';
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
    <label>نام مونتاژکننده/خیاط</label>
    <select name="user_name" class="form-control select2" required>
        <?php
                    echo '<option value="' . $output_row['username'] . '">' . $user_name . '</option>';
        if ($user_result->num_rows > 0) {
            while ($user_row = $user_result->fetch_assoc()) {
                echo '<option value="' . $user_row['id'] . '">' . $user_row['username'] . '</option>';
            }
        } else {
            echo "<option value=''>نتیجه‌ای یافت نشد</option>";
        }
        ?>
    </select>
</div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="<?php echo $update_id; ?>"name="record_id">
                        <button class="btn btn-primary" name="updated">بروزرسانی خروج</button>
                    </div>
                </div>
            </form>
        </div>
    </nav>
</div>
<?php
}
require_once '../../../footer.php';
?>