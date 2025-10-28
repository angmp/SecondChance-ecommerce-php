<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$host = 'localhost'; 
$dbname = 'sc_db'; 
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Retrieve store information based on logged-in user's session
$userId = $_SESSION['userId'];

// Retrieve shop data
$sqlShop = "SELECT * FROM shop WHERE userId = :userId LIMIT 1";
$stmtShop = $pdo->prepare($sqlShop);
$stmtShop->execute(['userId' => $userId]);
$shop = $stmtShop->fetch(PDO::FETCH_ASSOC);

// Retrieve products related to shopId
$shopId = $shop['shopId']; // shopId from the shop found
$sqlProducts = "SELECT * FROM product WHERE shopId = :shopId";
$stmtProducts = $pdo->prepare($sqlProducts);
$stmtProducts->execute(['shopId' => $shopId]);
$products = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Funny's Shop</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
        }
    
        .header nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #ff69b4;
            font-weight: 600;
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
            padding: 20px;
        }
        .container {
            display: flex;
            margin: 20px;
        }

        nav {
            width: 200px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        nav h2 {
            margin: 0 0 20px 0;
            font-size: 18px;
            color: #333;
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
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #333;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: #e6f7f7;
        }

        nav ul li a.active {
            background-color: #b3e4e4;
            color: #000;
        }

        nav ul li a .icon {
            margin-right: 10px;
            font-size: 18px;
        }

        nav ul li a .text {
            font-size: 14px;
        }
        .main-content {
            width: 80%;
            padding: 20px;
        }
        .main-content h1 {
            font-size: 24px;
            color: #00bfa5;
        }
        .main-content .shop-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .main-content .shop-info img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
            margin-right: 20px;
        }
        .main-content .shop-info .details {
            display: flex;
            align-items: center;
        }
        .main-content .shop-info .details div {
            margin-right: 20px;
        }
        .main-content .shop-info .details div i {
            margin-right: 5px;
        }
        .main-content .shop-info .details .edit-btn {
            background-color: #00bfa5;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .main-content .products {
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 20px; 
            justify-content: center; 
            margin-top: 20px; 
        }

        .main-content .products .product {
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
            text-align: center;
            height: 350px; 
            display: flex;
            flex-direction: column; 
            justify-content: space-between; 
            transition: transform 0.3s, box-shadow 0.3s; 
        }

        .main-content .products .product:hover {
            transform: translateY(-5px); 
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2); 
        }

        .main-content .products .product img {
            max-width: 100%;
            max-height: 150px; 
            object-fit: contain; 
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .main-content .products .product p {
            margin: 10px 0;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }

        .main-content .products .product .price {
            font-weight: bold;
            color: #00bfa5;
            font-size: 16px;
        }

        .main-content .shop-info .edit-btn {
            background-color: #00bfa5;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .main-content .shop-info .edit-btn:hover {
            background-color: #019a8a;
        }

        /* Responsivitas */
        @media (max-width: 768px) {
            .main-content .products {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            }

            .main-content .products .product {
                height: auto; 
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

   <div class="container">
        <nav>
            <ul>
                <li><a href="seller_dashboard.php">Dashboard</a></li>
                <li><a href="add_product.php">Add Products</a></li>
                <li><a href="manage_product.php">Manage Products</a></li>
                <li><a href="#">Log-out</a></li>
            </ul>
        </nav>
        
        <main class="main-content">
      <!-- Display Shop Info -->
      <div class="shop-info">
            <div class="details">
                <div>
                    <h1><?php echo htmlspecialchars($shop['shopName']); ?></h1>
                    <div>
                        <i class="fas fa-box"></i> Products: <?php echo count($products); ?>
                        <i class="fas fa-clock"></i> <?php echo htmlspecialchars($shop['operationalHours']); ?>
                    </div>
                </div>
                <a href="edit_store.php?id=<?php echo $shop['shopId']; ?>" class="edit-btn" style="text-decoration: none;">Edit</a>
            </div>
        </div>

        <h2>All Products</h2>

        <!-- Display Products -->
        <div class="products">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img alt="<?php echo htmlspecialchars($product['productName']); ?>" src="uploads/<?php echo htmlspecialchars($product['productPhoto']); ?>" width="300" height="300"/>
                    <p><?php echo htmlspecialchars($product['productName']); ?></p>
                    <p class="price">Rp. <?php echo number_format($product['productPrice'], 0, ',', '.'); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>