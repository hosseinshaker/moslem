<?php
$title_page="صفحه اصلی سامانه";
require_once 'header.php';
?>
<div class="main-content">
<nav class="row">
 <nav class="col-md-4">
     <nav class="card">
         <nav class="card-header">
             <h6>هشدار موجودی محصول در انبار</h6>
         </nav>
         <nav class="card-body">
         <?php
function displayLowStockProducts($connection) {
    // افزودن یک محدوده بالایی برای productCount
    $maxCount = 10000; // مثلاً 10000 به عنوان محدوده بالایی

    $sql = "SELECT * FROM primaryproduct WHERE productCount < minStock AND productCount < $maxCount";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='table'><tr><th>ID</th><th>نام محصول</th><th>موجودی فعلی</th><th>حداقل موجودی</th></tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["id"]."</td><td>".$row["product_name"]."</td><td>".$row["productCount"]."</td><td>".$row["minStock"]."</td></tr>";
        }

        echo "</table>";
    } else {
        echo "هیچ محصولی با موجودی کم یافت نشد.";
    }

    $connection->close();
}

displayLowStockProducts($connection);
?>


         </nav>
     </nav>
 </nav>
    <nav class="col-md-4">
        <nav class="card">
            <nav class="card-header">
                <h6>پشتیبان گیری از اطلاعات</h6>
            </nav>
            <nav class="card-body">
                <a class="btn btn-success" href="backup.php">مشاهده</a>
            </nav>
        </nav>
    </nav>
    <nav class="col-md-4">
        <nav class="card">
            <nav class="card-header">
                <h6>خروج از سامانه</h6>
            </nav>
            <nav class="card-body">
                <a class="btn btn-danger" href="exit.php">خروج</a>
            </nav>
        </nav>
    </nav>
</nav>
</div>
<?php require_once 'footer.php';?>