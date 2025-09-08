<?php
session_start();

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

// Get product ID from URL
if (!isset($_GET['id'])) {
    die("Product ID is required.");
}

$productId = $_GET['id'];

// Fetch product data from database
try {
    $stmt = $pdo->prepare("SELECT * FROM product WHERE productId = :productId");
    $stmt->execute(['productId' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Product not found.");
    }
} catch (PDOException $e) {
    die("Error fetching product: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Edit Products - Second Chance
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
  <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .product-image {
            display: block;
            margin: 0 auto 20px;
            max-width: 100%;
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #444;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            margin-top: 8px;
            color: #333;
        }

        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: #44c8c0;
        }

        .form-buttons {
            text-align: center;
        }

        .form-buttons button {
            padding: 12px 20px;
            font-size: 16px;
            background-color: #44c8c0;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            max-width: 200px;
        }

        .form-buttons button:hover {
            background-color: #36b1ad;
        }

        .form-buttons button:focus {
            outline: none;
        }
    </style>
 </head>
 <body>
 <div class="container">
        <h2>Edit Products</h2>
        <img 
            class="product-image"
            alt="Product Image" 
            src="uploads/<?php echo htmlspecialchars($product['productPhoto']); ?>" 
        />
        <form method="POST" action="update_product.php">
            <input type="hidden" name="productId" value="<?php echo htmlspecialchars($product['productId']); ?>"/>
            
            <div class="form-group">
                <label for="product-name">Product's Name</label>
                <input 
                    id="product-name" 
                    name="productName" 
                    type="text" 
                    value="<?php echo htmlspecialchars($product['productName']); ?>" 
                    required
                />
            </div>
            
            <div class="form-group">
                <label for="price">Price</label>
                <input 
                    id="price" 
                    name="productPrice" 
                    type="text" 
                    value="<?php echo htmlspecialchars($product['productPrice']); ?>" 
                    required
                />
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea 
                    id="description" 
                    name="productDesc" 
                    rows="3"
                    required
                ><?php echo htmlspecialchars($product['productDesc']); ?></textarea>
            </div>
            
            <div class="form-buttons">
                <button type="submit">Save</button>
            </div>
        </form>
    </div>
</body>
</html>
