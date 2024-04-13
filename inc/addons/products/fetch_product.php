<?php
// fetch_product.php

// Include database connection file

require_once '../../../database.php';
$output = '';
if (isset($_POST["query"])) {
    $search = $_POST["query"];
    $query = "SELECT * FROM products WHERE product_name LIKE '%$search%' OR productqr LIKE '%$search%'";
    $result = mysqli_query($connection, $query);
    $output = '<ul class="list-unstyled">';
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<li>' . $row["product_name"] . '</li>';
        }
    } else {
        $output .= '<li>محصول یافت نشد</li>';
    }
    $output .= '</ul>';
}
echo $output;
?>
