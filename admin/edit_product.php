<?php
session_start();
include 'db_connect.php'; // Include the database connection

// Check if productId is set in the URL
if (!isset($_GET['productId'])) {
    $_SESSION['error'] = "Product not found.";
    header("Location: manage_products.php");
    exit();
}

// Fetch the product details from the database
$productId = $_GET['productId'];
$stmt = $conn->prepare("SELECT * FROM product WHERE productId = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Product not found.";
    header("Location: manage_products.php");
    exit();
}

$product = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit Product</title>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <h1>Edit Product</h1>
        </div>

        <div class="main-content">
            <h2>Edit Product Details</h2>
            <form action="update_product.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="productId" value="<?php echo $product['productId']; ?>">
                <label for="productName">Product Name:</label>
                <input type="text" name="productName" id="productName" value="<?php echo htmlspecialchars($product['productName']); ?>" required>
                
                <label for="productDesc">Description:</label>
                <br>
                <textarea name="productDesc" id="productDesc" required><?php echo htmlspecialchars($product['productDesc']); ?></textarea>
                <br>

                <label for="productCategory">Category:</label>
                <select name="productCategory" id="productCategory" required>
                    <option value="Shirts" <?php echo ($product['productCategory'] == 'Shirts') ? 'selected' : ''; ?>>Shirts</option>
                    <option value="Pants" <?php echo ($product['productCategory'] == 'Pants') ? 'selected' : ''; ?>>Pants</option>
                    <option value="Sweaters & Hoodies" <?php echo ($product['productCategory'] == 'Sweaters & Hoodies') ? 'selected' : ''; ?>>Sweaters & Hoodies</option>
                    <option value="Accessories" <?php echo ($product['productCategory'] == 'Accessories') ? 'selected' : ''; ?>>Accessories</option>
                    <option value="Footwear" <?php echo ($product['productCategory'] == 'Footwear') ? 'selected' : ''; ?>>Footwear</option>
                </select>
                
                <label for="productPrice">Price:</label>
                <input type="number" name="productPrice" id="productPrice" value="<?php echo htmlspecialchars($product['productPrice']); ?>" required>
                
                <label for="productQuantity">Quantity:</label>
                <input type="number" name="productQuantity" id="productQuantity" value="<?php echo htmlspecialchars($product['productQuantity']); ?>" required>
                
                <label for="productPhoto">Upload New Image:</label>
                <input type="file" name="productPhoto" id="productPhoto">
                
                <button type="submit">Update Product</button>
                <button type="button" onclick="window.location.href='manage_products.php';">Cancel</button>
            </form>
        </div>
    </div>
</body>
</html>