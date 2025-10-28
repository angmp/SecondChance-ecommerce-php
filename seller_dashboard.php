<!DOCTYPE html>
<?php
session_start();
require 'db_connect.php';

// Periksa apakah user sudah login
if (!isset($_SESSION['userId'])) {
    // Redirect ke halaman login jika user belum login
    header("Location: user_login.php");
    exit();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Chance Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
        }

        .nav-links {
            display: flex;
            justify-content: center;
            background-color: #FBFFE9;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: #EF7FBF;
            margin-right: 20px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-links a:hover {
            background-color: #e6f7f7;
        }

        .nav-links a.active {
            background-color: #b3e4e4;
            color: #000;
        }

        .container {
            display: flex;
            margin: 20px auto;
            max-width: 1200px;
        }

        nav {
            width: 220px;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            margin-bottom: 15px;
        }

        nav ul li a {
            display: block;
            text-decoration: none;
            color: #333;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        nav ul li a:hover, nav ul li a.active {
            background-color: #CBF2F1;
            color: black;
        }

        .content {
            flex-grow: 1;
            margin-left: 30px;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .header p {
            margin: 5px 0 0;
            color: #555;
        }

        .card-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .card {
            flex: 1;
            background-color: #EF7FBF;
            color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            min-width: 150px;
        }

        .card h3 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .card p {
            margin: 5px 0 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            color: #333;
            text-transform: uppercase;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .status {
            border-radius: 12px;
            padding: 5px 10px;
            text-align: center;
            font-size: 12px;
            color: #fff;
        }

        .completed {
            background-color: #28a745;
        }

        .failed {
            background-color: #dc3545;
        }

        .pending {
            background-color: #ffc107;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            nav {
                width: 100%;
                margin-bottom: 20px;
            }

            .content {
                margin-left: 0;
            }

            .card-container {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>

 <!-- Navigation Links -->
 <div class="nav-links">
        <a href="seller_dashboard.php">Home</a>
        <a href="store.php">Store</a>
    </div>


    <!-- Sidebar Navigation -->
    <div class="container">
        <nav>
            <ul>
                <li><a href="seller_dashboard.php" class="active">Dashboard</a></li>
                <li><a href="add_product.php">Add Products</a></li>
                <li><a href="manage_product.php">Manage Products</a></li>
                <li><a href="index.php">Log-out</a></li>
            </ul>
        </nav>

        <!-- Dashboard Content -->
        <div class="content">
            <div class="header">
                <h1>Dashboard</h1>
                <p>Jan 01 - Jan 28</p>
            </div>
            <div class="card-container">
                <div class="card">
                    <h3>Rp 3,1 jt</h3>
                    <p>+22%</p>
                </div>
                <div class="card">
                    <h3>21</h3>
                    <p>Orders</p>
                </div>
            </div>

            <div class="orders">
                <h3>Latest Orders</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Produk</th>
                            <th>Tanggal</th>
                            <th>Customer</th>
                            <th>Persiapan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#5120001</td>
                            <td>Formal Fit Vintage Tee</td>
                            <td>Jan 10, 2024</td>
                            <td>Nicky</td>
                            <td>Rp 150.000</td>
                            <td><span class="status completed">Selesai</span></td>
                        </tr>
                        <tr>
                            <td>#5120002</td>
                            <td>Formal Fit Vintage Tee</td>
                            <td>Jan 12, 2024</td>
                            <td>Laura</td>
                            <td>Rp 150.000</td>
                            <td><span class="status failed">Dibatalkan</span></td>
                        </tr>
                        <tr>
                            <td>#5120003</td>
                            <td>Formal Fit Vintage Tee</td>
                            <td>Jan 15, 2024</td>
                            <td>Rayen</td>
                            <td>Rp 100.000</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
