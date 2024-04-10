<?php
$title_page="صفحه اصلی سامانه";
require_once '../../../header.php';

//ثبت کاربر در دیتابیس
if(isset($_POST['send'])){
    $username = $_POST['username'];
    // درج اطلاعات در جدول
    $query = "INSERT INTO users (username) VALUES ('$username')";
    mysqli_query($connection, $query);

    $alert_success='
    <nav class="row">
            <nav class="col-12 col-md-2"></nav>
            <nav class="col-12 col-md-8">
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        کاربر با موفقیت ثبت شد!.
                    </div>
                </div>
            </nav>
            <nav class="col-12 col-md-2"></nav>
        </nav>
    ';
}
?>

<div class="main-content">
    <section class="section">
        <?php

        if (isset($alert_success)){
            echo $alert_success;
        }
        ?>
        <div class="row">
            <nav class="col-12 col-md-2"></nav>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>فرم ثبت کاربر جدید</h4>
                    </div>
                    <div class="card-body">
                        <form method="post">

                            <div class="form-group">
                                <label>نام کاربر:</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>

                            <div class="card-footer text-right">
                                <input type="submit" class="btn btn-primary mr-1" name="send" value="افزودن کاربر">
                            </div>

                        </form>
                    </div>

                </div>


            </div>
            <nav class="col-12 col-md-3"></nav>


        </div>

    </section>
</div>
<?php require_once '../../../footer.php';?>