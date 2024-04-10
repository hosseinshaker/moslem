<?php
$title_page = "ثبت  محصول  جدید";
require_once '../../../header.php';

// بررسی ارسال فرم
if(isset($_POST['insert'])) {
    $product_name = $_POST['product_name'];
    $material_ids = $_POST['material_id'];
    $material_quantities = $_POST['material_quantity'];
    $salary = $_POST['salary'];
    // ذخیره اطلاعات در جدول products
    $insert_query = "INSERT INTO products (product_name, salary) VALUES ('$product_name', '$salary ')";
    $insert_result = mysqli_query($connection, $insert_query);
    $product_id = mysqli_insert_id($connection);

    // ذخیره اطلاعات مواد اولیه در جدول product_materials
    for($i = 0; $i < count($material_ids); $i++) {
        $material_id = $material_ids[$i];
        $material_quantity = $material_quantities[$i];
        $insert_material_query = "INSERT INTO product_materials(product_id, material_id, quantity,product_name) VALUES (?, ?, ?, ?)";
        $stmt2 = mysqli_prepare($connection, $insert_material_query);
        mysqli_stmt_bind_param($stmt2, "iids", $product_id, $material_id, $material_quantity, $product_name);
        mysqli_stmt_execute($stmt2);
    }
    // نمایش پیام موفقیت ثبت محصول
    $message_data = "True";
}

// دریافت لیست مواد اولیه
$query = "SELECT * FROM primaryproduct";
$result = mysqli_query($connection, $query);
?>

<div class="main-content">
    <nav class="row">
        <?php
        if (!empty($message_data) && $message_data == "True") :
        ?>
            <nav class="col-12 col-md-12 col-lg-12">
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        محصول با موفقیت ثبت شد
                    </div>
                </div>
            </nav>
        <?php
        endif;
        ?>
        <div class="col-12 col-md-3 col-lg-1"></div>
        <div class="col-12 col-md-6 col-lg-10">
            <form method="post">
                <div class="card">
                    <div class="card-header">
                        <h4>افزودن محصول جدید</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>نام محصول</label>
                            <input type="text" class="form-control" name="product_name" required>
                        </div>

                        <div class="form-group">
                            <label>انتخاب مواد اولیه تولید</label>
                            <div id="materialContainer">
                                <div class="materialGroup">
                                    <select name="material_id[]" class="form-control select2" >
                                        <option value="">انتخاب*</option>
                                        <?php
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $row['id'] . '">' . $row['product_name'] . '</option>';
                                            }
                                        } else {
                                            echo "<option value=''>نتیجه‌ای یافت نشد</option>";
                                        }
                                        ?>
                                    </select>

                                    <div class="form-group">
                                        <label>تعداد محصول اولیه مورد نیاز</label>
                                        <input type="text" class="form-control" placeholder="مقدار/ابعاد"  name="material_quantity[]" >
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger removeMaterial" style="margin-bottom: 10px;">حذف</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-success addMaterial">افزودن ماده اولیه</button>
                        </div>

                        <div class="form-group">
                            <label>دستمزد تولید/مونتاژ</label>
                            <input type="number" class="form-control" placeholder="دستمزد"  name="salary" required>
                        </div>

                        <button class="btn btn-primary" name="insert">افزودن</button>
                    </div>
                </div>
            </form>

            <script src="<?php echo $base_url; ?>/assets/js/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('.select2').select2();

                    $('.addMaterial').click(function () {
                        var materialContainer = $('#materialContainer');
                        var newMaterialGroup = $('<div class="materialGroup"></div>');

                        var selectElement = $('<select name="material_id[]" class="form-control select2" ></select>');
                        selectElement.append('<option value="">انتخاب*</option>');

                        // اضافه کردن گزینه‌های مواد اولیه
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            mysqli_data_seek($result, 0);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "selectElement.append('<option value=\"{$row['id']}\">{$row['product_name']}</option>');";
                            }
                        } else {
                            echo "selectElement.append('<option value=\'\'>نتیجه‌ای یافت نشد</option>');";
                        }
                        ?>

                        var quantityInput = $('<div class="form-group">' +
                            '<label>تعداد محصول اولیه مورد نیاز</label>' +
                            '<input type="text" class="form-control" placeholder="مقدار/ابعاد" name="material_quantity[]" >' +
                            '</div>');
                        var removeButton = $('<button type="button" class="btn btn-sm btn-danger removeMaterial" style="margin-bottom: 10px;">حذف</button>');
                        removeButton.click(function () {
                            $(this).parent().remove();
                        });

                        newMaterialGroup.append(selectElement);
                        newMaterialGroup.append(quantityInput);
                        newMaterialGroup.append(removeButton);

                        materialContainer.append(newMaterialGroup);
                    });

                    $(document).on('click', '.removeMaterial', function () {
                        $(this).parent().remove();
                    });
                });
            </script>
        </div>
        <div class="col-12 col-md-3 col-lg-1"></div>
    </nav>
</div>
<?php require_once '../../../footer.php'; ?>