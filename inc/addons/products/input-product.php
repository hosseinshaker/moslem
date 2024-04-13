<?php
$title_page = "ورود محصولات جدید";
require_once '../../../header.php';
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
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="productName">نام محصول یا بارکد</label>
                                <input type="text" class="form-control" id="productName" name="productName">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="productQuantity">تعداد</label>
                                <input type="number" class="form-control" id="productQuantity" name="productQuantity">
                            </div>
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
                        <div id="productInfo"></div>
                        <button type="submit" class="btn btn-primary" name="insert">ورود</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-1 col-lg-1"></div>
    </nav>
</div>

<?php require_once '../../../footer.php'; ?>

<script>
$(document).ready(function () {
    $('#productName').keyup(function () {
        var query = $(this).val();
        if (query != '') {
            $.ajax({
                url: "fetch_product.php",
                method: "POST",
                data: {query: query},
                success: function (data) {
                    $('#productInfo').fadeIn();
                    $('#productInfo').html(data);
                    // برای انتخاب محصول با کلیک بر روی آن
                    $('#productInfo li').click(function () {
                        var selectedProduct = $(this).text();
                        $('#productName').val(selectedProduct);
                        $('#productInfo').fadeOut();
                    });
                }
            });
        }
    });
});

</script>
