<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    header("Location: user_login.php");
    exit();
}

// Check if shopId is set in session
if (!isset($_SESSION['shopId'])) {
    echo '<script>alert("Shop ID is not set. Please log in to a shop.");</script>';
    header("Location: user_login.php");
    exit();
}

$shopId = $_SESSION['shopId']; 
$userId = $_SESSION['userId']; 

// Connect to database
$host = 'localhost';
$dbname = 'sc_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ambil semua produk berdasarkan shopId
    $sql = "SELECT * FROM product WHERE shopId = :shopId ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['shopId' => $shopId]);

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error connecting to database: " . $e->getMessage());
}

// Delete product logic
if (isset($_GET['delete_id'])) {
    $productId = $_GET['delete_id'];

    // Prepare and execute delete query
    $sql = "DELETE FROM product WHERE productId = :productId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['productId' => $productId]);

    // Redirect back to the product page after deletion
    header("Location: manage_product.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Chance - My Products</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
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

        .container {
            display: flex;
            margin: 20px;
        }

        .content {
            flex-grow: 1;
            margin-left: 20px;
            max-width: 100%;
        }

        .product {
            background: #fff;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            padding: 20px;
        }

        .product img {
            width: 150px;
            height: auto;
            border-radius: 10px;
            margin-right: 20px;
        }

        .product-details {
            flex-grow: 1;
            text-align: left;
        }

        .product-details h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .product-details p {
            margin: 5px 0;
            color: #777;
        }

        .product-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-actions button {
            padding: 8px 15px;
            border: none;
            background: #44c8c0;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
            z-index: 1;
        }

        .dropdown-content button {
            width: 100%;
            padding: 10px;
            text-align: left;
            background-color: #fff;
            border: none;
            cursor: pointer;
            font-size: 14px;
            color: black;
        }

        .dropdown-content button:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
    <script>
        // Function to confirm product deletion
        function confirmDelete(productId) {
            var confirmation = confirm("Are you sure you want to delete this product?");
            if (confirmation) {
                window.location.href = "manage_product.php?delete_id=" + productId;
            }
        }
    </script>
</head>
<body>

 <!-- Navigation Links -->
<div class="nav-links">
        <a href="seller_dashboard.php">Home</a>
        <a href="store.php">Store</a>
    </div>

    <div class="container">
        <nav>
            <ul>
                <li><a href="seller_dashboard.php">Dashboard</a></li>
                <li><a href="add_product.php">Add Products</a></li>
                <li><a href="manage_product.php" class="active">Manage Products</a></li>
                <li><a href="logout.php">Log-out</a></li>
            </ul>
        </nav>

        <div class="content">
            <h2>My Products</h2>

            <!-- Menampilkan Produk -->
            <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="uploads/<?php echo htmlspecialchars($product['productPhoto']); ?>" alt="<?php echo htmlspecialchars($product['productName']); ?>">
                    <div class="product-details">
                        <h3><?php echo htmlspecialchars($product['productName']); ?></h3>
                        <p><?php echo htmlspecialchars($product['productDesc']); ?></p>
                        <p><strong>Price:</strong> Rp. <?php echo number_format($product['productPrice'], 0, ',', '.'); ?></p>
                    </div>
                    <div class="product-actions">
                        <button onclick="window.location.href='store.php?id=<?php echo $product['productId']; ?>'">Show</button>
                        <button onclick="window.location.href='edit_product_seller.php?id=<?php echo $product['productId']; ?>'">Edit</button>
                        <div class="dropdown">
                            <button>...</button>
                            <div class="dropdown-content">
                                <!-- Trigger delete with confirmation -->
                                <button onclick="confirmDelete(<?php echo $product['productId']; ?>)">Delete</button>
                                <button>Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
