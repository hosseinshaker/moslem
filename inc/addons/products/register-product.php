<?php
$title_page="ثبت محصول جدید";
require_once '../../../header.php';
// پارامترهای محصول اولیه
if(isset($_POST['insert'])){
    $product_name = $_POST['product_name'];//نام محصول اولیه
    $productqr = $_POST['productqr'];//شناسه محصول
    $minStock = $_POST['minStock'];//حداقل موجودی برای اخطار افزایش محصول
    $pack = $_POST['pack'];
    // چک کردن وجود شناسه در دیتابیس
    $check_query = "SELECT * FROM products WHERE productqr = ?";
    $check_stmt = $connection->prepare($check_query);
    $check_stmt->bind_param("i", $productqr);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // اگر شناسه تکراری است، خطا داده شود
        $tekrari= "خطا: این شناسه قبلاً در دیتابیس وجود دارد.";
    } else {
        // اگر شناسه تکراری نیست، رکورد جدید اضافه شود
        $insert_query = "INSERT INTO products (product_name, productqr, minStock,pack) VALUES (?, ?, ?,?)";
        $insert_stmt = $connection->prepare($insert_query);
        $insert_stmt->bind_param("siii", $product_name, $productqr, $minStock,$pack);

        if ($insert_stmt->execute() === TRUE) {
            $message_data= "True";
        } else {
            echo "خطا در ثبت محصول : " . $connection->error;
        }
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
محصول  با موفقیت ثبت شد
                    </div>
                    </div>
</nav>
<?php
endif;

if(!empty($tekrari)){
?>

<nav class="col-12 col-md-12 col-lg-12">
<div class="alert alert-danger alert-dismissible show fade">
                      <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                          <span>×</span>
                        </button>
                        خطا: این شناسه قبلاً در دیتابیس وجود دارد.
                                        </div>
                    </div>
</nav>

<?php
}





?>
<div class="col-12 col-md-3 col-lg-3"></div>
<div class="col-12 col-md-6 col-lg-6">

            <form method="post">
                            <div class="card">
                                <div class="card-header">
                                    <h4>افزودن محصول  جدید</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>نام محصول </label>
                                        <input type="text" class="form-control" name="product_name"required>
                                    </div>
                                    <div class="form-group ">
                                        <label>بارکد محصول(شناسه)</label>
                                        <input type="number" class="form-control" name="productqr">
                                    </div>
                                    <div class="form-group ">
                                        <label>تعداد محصول در هر بسته</label>
                                        <input type="number" class="form-control" name="pack">
                                    </div>
                                    <div class="form-group">
                                        <label>حداقل موجودی برای اخطار اتمامی محصول</label>
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