<?php
$title_page = "کاهش موجودی کاربر";
require_once '../../../header.php';

// دریافت نام کاربران و نام محصولات اولیه
$getUsernamesQuery = "SELECT id, username FROM users";
$usernamesResult = $connection->query($getUsernamesQuery);

$getProductsQuery = "SELECT id, product_name FROM primaryproduct";
$productsResult = $connection->query($getProductsQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // یافتن شناسه کاربر بر اساس نام کاربری
    $userIdQuery = "SELECT id FROM users WHERE username = ?";
    $stmt = $connection->prepare($userIdQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        // بررسی موجودی کاربر و به روز رسانی آن
        $stockQuery = "SELECT * FROM users_stock WHERE user_id = ? AND material_id = ?";
        $stmt = $connection->prepare($stockQuery);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $stock = $result->fetch_assoc();
            if ($stock['material_number'] >= $quantity) {
                // کاهش موجودی کاربر
                $updateStockQuery = "UPDATE users_stock SET material_number = material_number - ? WHERE user_id = ? AND material_id = ?";
                $stmt = $connection->prepare($updateStockQuery);
                $stmt->bind_param("iii", $quantity, $user_id, $product_id);
                $stmt->execute();
                $message_up = "موجودی انبار کاربر کاهش یافت.";

                // افزایش موجودی محصول در جدول primaryproduct
                $addToPrimaryProductQuery = "UPDATE primaryproduct SET productCount = productCount + ? WHERE id = ?";
                $stmt = $connection->prepare($addToPrimaryProductQuery);
                $stmt->bind_param("ii", $quantity, $product_id);
                $stmt->execute();
            } else {
                $message_error = "موجودی کافی نیست.";
            }
        } else {
            $message_error = "محصولی در انبار کاربر یافت نشد.";
        }
    } else {
        $message_error = "کاربر یافت نشد.";
    }
}
?>
<!-- فرم و پیام‌های نمایشی -->
<div class="main-content">
    <!-- ... سایر محتویات ... -->
    <?php if
(isset($message_error)): ?>
<div class="alert alert-danger">
<?php echo $message_error; ?>
</div>
<?php elseif (isset($message_up)): ?>
<div class="alert alert-success">
<?php echo $message_up; ?>
</div>
<?php endif; ?>
<div class="card">
<div class="card-header">
<h4>کاهش موجودی کاربر</h4>
</div>
<div class="card-body">
<form action="" method="post">
<div class="form-group">
<label for="username">نام کاربر</label>
<select class="form-control select2" id="username" name="username" required>
<?php while ($row = $usernamesResult->fetch_assoc()) : ?>
<option value="<?php echo $row['username']; ?>"><?php echo $row['username']; ?></option>
<?php endwhile; ?>
</select>
</div>
<div class="form-group">
<label for="product_id">نام محصول</label>
<select class="form-control select2" id="product_id" name="product_id" required>
<?php while ($row = $productsResult->fetch_assoc()) : ?>
<option value="<?php echo $row['id']; ?>"><?php echo $row['product_name']; ?></option>
<?php endwhile; ?>
</select>
</div>
<div class="form-group">
<label for="quantity">تعداد</label>
<input type="number" class="form-control" id="quantity" name="quantity" required>
</div>
<button type="submit" class="btn btn-primary">بروزرسانی موجودی</button>
</form>
</div>
</div>
</div>

</div>
<?php require_once '../../../footer.php'; ?>