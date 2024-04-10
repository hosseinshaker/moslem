<?php
$title_page = "خروج محصول از انبار";
require_once '../../../header.php';
$sql = "SELECT * FROM products";
$result = $connection->query($sql);

// دریافت اطلاعات از جدول users
$user_sql = "SELECT * FROM users";
$user_result = $connection->query($user_sql);

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
<?php
if(isset($sucsses_out_product)){
    echo'
    <div class="alert alert-success alert-dismissible show fade">
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        خروج محصول با موفقیت ثبت شد!
    </div>
    </div>
    ';
}
?>
<?php
if(isset($mess_eror_product)){
    echo'
    <div class="alert alert-danger alert-dismissible show fade">
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        مقدار محصول اولیه در انبار کافی نیست
    </div>
    </div>
    ';
}
?>
            </nav>
        <div class="col-12 col-md-3 col-lg-1"></div>
        <div class="col-12 col-md-6 col-lg-10">
        <form method="post" action="process.php">
                <div class="card">
                    <div class="card-header">
                        <h4>خروج محصول از انبار</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>تاریخ خروج از انبار</label>
                            <input  id="datepicker-check-in" name="date_output" class="form-control"required>
                        </div>
                        <div class="form-group">
                            <label>انتخاب محصول  </label>
                            <div id="materialContainer">
                                <div class="materialGroup">
                                    <select name="product_name" class="form-control select2" required>
                                        <option value="">انتخاب*</option>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . $row['id'] . '">' . $row['product_name'] . '</option>';
                                            }
                                        } else {
                                            echo "<option value=''>نتیجه‌ای یافت نشد</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="form-group">
                                        <label>تعداد محصول</label>
                                        <input type="number" class="form-control" placeholder="مقدار" name="quantity" required>
                                    </div>
                            
                                    <div class="form-group">
    <label>انتخاب طرح محصول</label>
    <select name="product_pattern" class="form-control select2" required>
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
    <select name="product_color" class="form-control select2" required>
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
    <label>نام مونتاژکننده/خیاط</label>
    <select name="user_name" class="form-control select2" required>
        <option value="">انتخاب*</option>
        <?php
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
                        <button class="btn btn-primary" name="calculate">محاسبه خرج کار و خروج محصول</button>
                    </div>
                </div>
            </form>
        </div>
    </nav>
</div>
<?php require_once '../../../footer.php'; ?>