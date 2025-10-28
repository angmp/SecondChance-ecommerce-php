<?php
session_start();

if (!isset($_SESSION['userId']) || empty($_SESSION['userId'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['userId'];

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sc_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$productId = isset($_POST['productId']) ? (int)$_POST['productId'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

// Ambil informasi produk termasuk shopId
$sql = "SELECT productPrice, shopId FROM product WHERE productId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    $productPrice = $product['productPrice'];
    $shopId = $product['shopId'];  
    $totalPrice = $productPrice * $quantity;

    // Tambahkan produk ke tabel cart bersama dengan shopId
    $insertSql = "INSERT INTO cart (userId, productId, quantity, totalPrice, shopId) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("iiidi", $userId, $productId, $quantity, $totalPrice, $shopId);
    if ($stmt->execute()) {
        // Redirect ke cart.php setelah produk ditambahkan
        header("Location: cart.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Product not found.";
}

$stmt->close();
$conn->close();
?>