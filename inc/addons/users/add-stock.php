<?php
$title_page = "افزایش موجودی کاربر";
require_once '../../../header.php';
// دریافت نام کاربران از جدول users
$getUsernamesQuery = "SELECT id, username FROM users";
$usernamesResult = $connection->query($getUsernamesQuery);
// دریافت نام محصولات اولیه از جدول primaryproduct
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
    if ($result->num_rows == 0) {
        // ایجاد کاربر جدید اگر وجود نداشته باشد
        $createUserQuery = "INSERT INTO users (username) VALUES (?)";
        $stmt = $connection->prepare($createUserQuery);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $user_id = $stmt->insert_id;
    } else {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];
    }
    // بررسی موجودی کاربر برای محصول انتخاب شده
    $stockQuery = "SELECT * FROM users_stock WHERE user_id = ? AND material_id = ?";
    $stmt = $connection->prepare($stockQuery);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        // ایجاد رکورد جدید در صورت عدم وجود
        $insertStockQuery = "INSERT INTO users_stock (user_id, material_id, material_number) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($insertStockQuery);
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $message_ins="محصول اولیه به انبار کاربر اضافه شد";
    } else {
        // به روز رسانی موجودی موجود
        $updateStockQuery = "UPDATE users_stock SET material_number = material_number + ? WHERE user_id = ? AND material_id = ?";
        $stmt = $connection->prepare($updateStockQuery);
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
        $message_up="موجودی انبار کاربر آپدیت گردید.";
    }
    $stmt->execute();
    // کسر مقدار اضافه شده از موجودی محصول در جدول primaryproduct
    $deductFromPrimaryProductQuery = "UPDATE primaryproduct SET productCount = productCount - ? WHERE id = ?";
    $stmt = $connection->prepare($deductFromPrimaryProductQuery);
    $stmt->bind_param("ii", $quantity, $product_id);
    $stmt->execute();
}
// فرم برای ورودی‌های کاربر
?>
<div class="main-content">
    <div class="row">
        <div class="col-12">
        <?php if (isset($message_ins)): ?>
                <div class="alert alert-success">
                    <?php echo $message_ins; ?>
                </div>
            <?php elseif (isset($message_up)): ?>
                <div class="alert alert-info">
                    <?php echo $message_up; ?>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header">
                    <h4>افزایش موجودی کاربر</h4>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="username">نام کاربر</label>
                            <select class="form-control select2" id="username" name="username" required >
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
</div>

<?php require_once '../../../footer.php'; ?>
