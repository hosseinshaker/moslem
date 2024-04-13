<?php
$title_page = "ورود محصولات جدید";
require_once '../../../header.php';

?>

<div class="main-content">
    <nav class="row">

            <nav class="col-12 col-md-12 col-lg-12">
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
محصولات با موفقیت وارد شدند
                    </div>
                </div>
            </nav>
        <div class="col-12 col-md-1 col-lg-1"></div>
        <div class="col-12 col-md-10 col-lg-10">
            <form method="post">
                <div class="card">
                    <div class="card-header">
                        <h4><?php echo $title_page;?></h4>
                    </div>
                    <div class="card-body">
                    <nav class="form-row">
                        <div class="form-group col-md-8">
                            <label>نام محصول یا بارکد</label>
                    <select class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                        <option>انتخاب</option>
                      <option>محصول 1</option>
                      <option>محصول 2</option>
                    </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>تعداد</label>
                            <input type="number" class="form-control" name="productqr">
                        </div>
                    </nav>
                    <nav class="form-row">
                    <div class="form-group col-md-4">
                        <div class="form-group">
                                        <label>تاریخ ورود:</label>
                                        <input  id="datepicker-check-in" name="entryDate" class="form-control"required>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="form-group ">
                            <label>ساعت</label>
                            <input type="text" class="form-control" name="clock" value="<?php echo jdate("H:i");  ?>">
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="form-group ">
                        <label>شناسه ورود</label>
                            <input type="text" class="form-control" name="id" value="<?php echo rand(100,999999999999999999); ?>">
                        </div>
                    </nav>
                    </div>
                    <button class="btn btn-primary" name="insert">ورود</button>    
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-1 col-lg-1"></div>
    </nav>
</div>
<?php require_once '../../../footer.php'; ?>