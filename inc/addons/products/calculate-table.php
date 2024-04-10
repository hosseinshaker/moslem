<?php
$title_page = "محاسبه مقدار محصول اولیه هر محصول";
require_once '../../../header.php';

// دریافت اطلاعات فرم
if (isset($_POST['calculate'])) {
    $product_id = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    // بررسی وجود محصول در جدول products
    $product_query = $connection->prepare("SELECT * FROM products WHERE id = ?");
    $product_query->bind_param("i", $product_id);
    $product_query->execute();
    $product_result = $product_query->get_result();
    if ($product_result->num_rows > 0) {
        $product_row = $product_result->fetch_assoc();
        $product_name = $product_row['product_name'];
        // بررسی وجود محصول در جدول product_materials
        $material_query = $connection->prepare("SELECT * FROM product_materials WHERE product_id = ?");
        $material_query->bind_param("i", $product_id);
        $material_query->execute();
        $material_result = $material_query->get_result();
        if ($material_result->num_rows > 0) {
            $requiredMaterials = array();
            while ($material_row = $material_result->fetch_assoc()) {
                $material_id = $material_row['material_id'];
                $required_quantity = $material_row['quantity'] * $quantity;

                $material_name_query = $connection->prepare("SELECT product_name, productType FROM primaryproduct WHERE id = ?");
                $material_name_query->bind_param("i", $material_id);
                $material_name_query->execute();
                $material_name_result = $material_name_query->get_result();

                if ($material_name_result->num_rows > 0) {
                    $material_name_row = $material_name_result->fetch_assoc();
                    $material_name = $material_name_row['product_name'];
                    $material_type = $material_name_row['productType'];

                    $requiredMaterials[$material_name] = array('quantity' => $required_quantity, 'unit' => $material_type);
                } else {
                    echo "مواد اولیه مورد نیاز یافت نشد.";
                    break;
                }
            }
            // نمایش نتایج به کاربر
            if (!empty($requiredMaterials)) {
                echo'
                <div class="main-content">
    <nav class="row">
<div class="col-12">
    <div class="card">
                ';
                echo "<div class='card-header'>
                <h4>نیاز به مواد اولیه برای تولید $quantity عدد $product_name:</h4>
                </div>";
                echo '    <div class="card-body">
                <div class="table-responsive">
    
                        <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                            <thead>';
                echo "<tr><th>نام مواد اولیه</th><th>مقدار مورد نیاز</th><th>واحد</th></tr> </thead>
                <tbody>";
                foreach ($requiredMaterials as $material_name => $material_info) {
                    $required_quantity = $material_info['quantity'];
                    $unit = $material_info['unit'];
                    echo "<tr><td>$material_name</td><td>$required_quantity</td><td>$unit</td></tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "هیچ نیازی به مواد اولیه برای تولید $product_name وجود ندارد.";
            }
        } else {
            echo "محصول مورد نیاز برای این محصول یافت نشد.";
        }
    } else {
        echo'        <div class="alert alert-info">
        هیچ محصول اولیه‌ای یافت نشد.
    </div>';
    }
}
?>
            </div>
        </div>
    </div>
</div>
</div>
</nav>
</div>
<?php require_once '../../../footer.php'; ?>