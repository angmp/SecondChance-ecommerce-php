<?php
// Memulai session
session_start(); 

include 'header.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sc_db";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil transactionId dari URL
$transactionId = $_GET['transactionId'];

// Ambil detail transaksi
$sql = "SELECT t.transactionId, t.totalAmount, t.transactionDate, t.status, u.first_name, u.last_name, u.email 
        FROM transactions t 
        JOIN user_data u ON t.userId = u.userId 
        WHERE t.transactionId = '$transactionId'";
$result = $conn->query($sql);

// Ambil detail produk dalam transaksi
$detailsSql = "SELECT td.productId, p.productName, td.quantity, td.price 
               FROM transaction_details td 
               JOIN product p ON td.productId = p.productId 
               WHERE td.transactionId = '$transactionId'";
$detailsResult = $conn->query($detailsSql);

// Tampilkan detail pesanan
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Order Details</h2>';

if ($result->num_rows > 0) {
    $transaction = $result->fetch_assoc();
    echo '<p><strong>Transaction ID:</strong> ' . htmlspecialchars($transaction['transactionId']) . '</p>';
    echo '<p><strong>Date:</strong> ' . htmlspecialchars($transaction['transactionDate']) . '</p>';
    echo '<p><strong>Total Amount:</strong> Rp ' . number_format($transaction['totalAmount'], 2, ',', '.') . '</p>';
    echo '<p><strong>Status:</strong> ' . htmlspecialchars($transaction['status']) . '</p>';
    echo '<p><strong>Customer Name:</strong> ' . htmlspecialchars($transaction['first_name'] . ' ' . $transaction['last_name']) . '</p>';
    echo '<p><strong>Email:</strong> ' . htmlspecialchars($transaction['email']) . '</p>';

    // Tampilkan detail produk dalam transaksi
    if ($detailsResult->num_rows > 0) {
        echo '<h4>Product Details:</h4>';
        echo '<table>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>';

        while ($detailRow = $detailsResult->fetch_assoc()) {
            echo '<tr>
                    <td>' . htmlspecialchars($detailRow['productName']) . '</td>
                    <td>' . htmlspecialchars($detailRow['quantity']) . '</td>
                    <td>Rp ' . number_format($detailRow['price'], 2, ',', '.') . '</td>
                  </tr>';
        }

        echo '</table>';
    } else {
        echo '<p>No product details found for this transaction.</p>';
    }
} else {
    echo '<p>Transaction not found.</p>';
}

echo '</div>
</body>
</html>';

$conn->close(); // Menutup koneksi database
?>