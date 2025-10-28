<?php
session_start();

// Pastikan userId dan transactionId ada di session
if (!isset($_SESSION['userId']) || !isset($_SESSION['transactionId'])) {
    header("Location: index.php"); 
    exit();
}

$userId = $_SESSION['userId'];
$transactionId = $_SESSION['transactionId'];

// Koneksi ke database
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "sc_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil detail transaksi
$orderSql = "SELECT * FROM transactions WHERE transactionId = '$transactionId'";
$orderResult = $conn->query($orderSql);
$order = $orderResult->fetch_assoc();

// Ambil detail produk yang dibeli
$orderDetailsSql = "SELECT td.*, p.productName FROM transaction_details td JOIN product p ON td.productId = p.productId WHERE td.transactionId = '$transactionId'";
$orderDetailsResult = $conn->query($orderDetailsSql);

// Tampilkan konfirmasi
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
        }
        .order-summary {
            margin-bottom: 20px;
        }
        .order-summary p {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        .order-summary strong {
            font-size: 18px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Order Confirmation</h2>
        <p>Thank you for your purchase!</p>
        <p>Your transaction ID is: <strong><?php echo htmlspecialchars($transactionId); ?></strong></p>
        <h3>Your Orders</h3>
        <div class="order-summary">
            <?php while ($item = $orderDetailsResult->fetch_assoc()): ?>
                <p>
                    <span><?php echo htmlspecialchars($item['productName']); ?> (<?php echo $item['quantity']; ?>)</span>
                    <span>Rp <?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?></span>
                </p>
            <?php endwhile; ?>
            <p>
                <strong>
                    <span>Total</span>
                    <span>Rp <?php echo number_format($order['totalAmount'], 2, ',', '.'); ?></span>
                </strong>
            </p>
        </div>
        <p>Your order status is: <strong><?php echo htmlspecialchars($order['status']); ?></strong></p>
        <p>If you have any questions, please contact our support team.</p>
        <a href="index.php" class="btn">Continue Shopping</a>
    </div>
</body>
</html>

<?php
$conn->close(); // Menutup koneksi database
?>