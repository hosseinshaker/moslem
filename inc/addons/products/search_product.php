<?php
// Include database connection or any necessary files
require_once '../../../database.php';

// Check if productID is sent via POST
if(isset($_POST['productID'])) {
    // Get the product ID from POST data
    $productID = $_POST['productID'];

    // Query to fetch product details from the database based on productID
    $product_sql = "SELECT * FROM products WHERE productqr = '$productID'";
    $product_result = $connection->query($product_sql);

    if($product_result->num_rows > 0) {
        // Fetch product details
        $product_row = $product_result->fetch_assoc();

        // Prepare JSON response
        $response = array(
            'success' => true,
            'product' => array(
                'product_id' => $product_row['id'],
                'product_name' => $product_row['product_name'],
                'pack' => $product_row['pack'],
                'productqr' => $product_row['productqr']
                // Add more product details as needed
            )
        );

        // Return JSON response
        echo json_encode($response);
    } else {
        // Product not found
        $response = array(
            'success' => false,
            'message' => 'محصولی با این شناسه یافت نشد.'
        );
        echo json_encode($response);
    }
} else {
    // If productID is not sent via POST
    $response = array(
        'success' => false,
        'message' => 'شناسه محصول ارسال نشده است.'
    );
    echo json_encode($response);
}
?>
