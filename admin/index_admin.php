<?php
session_start();
include 'db_connect.php'; // Include the database connection

// Fetch active users, sellers, and products
$users = $conn->query("SELECT COUNT(*) as total FROM user_data");
$sellers = $conn->query("SELECT COUNT(*) as total FROM user_data WHERE is_seller = 1");
$products = $conn->query("SELECT COUNT(*) as total FROM product");

$userCount = $users->fetch_assoc()['total'];
$sellerCount = $sellers->fetch_assoc()['total'];
$productCount = $products->fetch_assoc()['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Second Chance Admin Dashboard</title>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <h1>Second Chance Admin Dashboard</h1>
        </div>
        
        <div class="sidebar">
            <ul>
                <li><a href="index_admin.php">Home</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="manage_sellers.php">Manage Sellers</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="login_admin.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h2>Statistics</h2>
            <div class="stats-container">
                <div class="stat-box user-stat">
                    <h3>Total Users</h3>
                    <p><?php echo $userCount; ?></p>
                    <a href="manage_users.php">Manage Users</a>
                </div>
                <div class="stat-box seller-stat">
                    <h3>Total Sellers</h3>
                    <p><?php echo $sellerCount; ?></p>
                    <a href="manage_sellers.php">Manage Sellers</a>
                </div>
                <div class="stat-box product-stat">
                    <h3>Total Products</h3>
                    <p><?php echo $productCount; ?></p>
                    <a href="manage_products.php">Manage Products</a>
                </div>
            </div>
        </div>

        <footer>
            <p>&copy; 2024 Second Chance</p>
        </footer>
    </div>
</body>
</html>