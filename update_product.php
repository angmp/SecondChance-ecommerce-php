<?php
// Database connection
$host = 'localhost';
$dbname = 'sc_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to database: " . $e->getMessage());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productDesc = $_POST['productDesc'];

    try {
        $stmt = $pdo->prepare("
            UPDATE product 
            SET productName = :productName, 
                productPrice = :productPrice, 
                productDesc = :productDesc 
            WHERE productId = :productId
        ");
        
        $stmt->execute([
            'productName' => $productName,
            'productPrice' => $productPrice,
            'productDesc' => $productDesc,
            'productId' => $productId
        ]);

        echo "Product updated successfully!";
        header("Location: manage_product.php");
        exit();
    } catch (PDOException $e) {
        die("Error updating product: " . $e->getMessage());
    }
}
?>
