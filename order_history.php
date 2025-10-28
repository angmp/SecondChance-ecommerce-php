<?php
session_start(); 

// Include header
include 'header.php';

// Konfigurasi koneksi database
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

// Pastikan userId tersedia di session
if (!isset($_SESSION['userId'])) {
    header("Location: login.php"); 
    exit();
}

$userId = $_SESSION['userId'];

// Mengambil data transaksi dengan prepared statement
$sql = "SELECT transactionId, totalAmount, transactionDate, status 
        FROM transactions 
        WHERE userId = ? 
        ORDER BY transactionDate DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
    <div class="flex space-x-8">
        <!-- Sidebar -->
        <aside class="w-1/4 bg-white p-4 rounded-lg shadow-sm">
            <nav>
                <ul class="space-y-4" id="menu">
                    <li>
                        <a href="profile_cust.php" class="flex items-center space-x-2 text-gray-700 p-2">
                            <i class="fas fa-th-large"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="order_history.php" class="flex items-center space-x-2 text-gray-700 p-2">
                            <i class="fas fa-history"></i>
                            <span>Order History</span>
                        </a>
                    </li>
                    <li>
                        <a href="cart.php" class="flex items-center space-x-2 text-gray-700 p-2">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Shopping Cart</span>
                        </a>
                    </li>
                    <li>
                        <a href="seller_registrasi.php" class="flex items-center space-x-2 text-gray-700 p-2">
                            <i class="fas fa-store"></i>
                            <span>Seller Center</span>
                        </a>
                    </li>
                    <li>
                        <a href="settings.php" class="flex items-center space-x-2 text-gray-700 p-2">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php" class="flex items-center space-x-2 text-gray-700 p-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Log-out</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="container">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Order History</h2>

            <?php if ($result->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['transactionId']) ?></td>
                            <td><?= htmlspecialchars($row['transactionDate']) ?></td>
                            <td>Rp <?= number_format($row['totalAmount'], 2, ',', '.') ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td>
                                <a href="order_details.php?transactionId=<?= urlencode($row['transactionId']) ?>" class="text-blue-600 hover:underline">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p class="text-gray-500">No orders found.</p>
            <?php endif; ?>

        </div>
    </div>
</body>
</html>

<?php
// Menutup koneksi database
$stmt->close();
$conn->close();
?>