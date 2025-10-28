<?php
session_start();
$host = 'localhost';
$username = 'root';
$password = ''; 
$database = 'sc_db';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Ambil productId dari parameter URL
$productId = isset($_GET['productId']) ? (int)$_GET['productId'] : 0;

$sql = "SELECT p.productId, p.productName, p.productDesc, p.productCategory, p.productPrice, p.productPhoto, s.shopName, s.city 
        FROM product p         JOIN shop s ON p.shopId = s.shopId
        WHERE p.productId = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <title><?php echo htmlspecialchars($product['productName']); ?></title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&amp;display=swap" rel="stylesheet"/>
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f9f9f9;
            }
            .container {
                max-width: 800px;
                margin: 20px auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }
            h2 {
                color: #00bfa5;
            }
            img {
                max-width: 100%;
                height: auto;
                border-radius: 5px;
            }
            .price {
                font-weight: bold;
                color: #00bfa5;
                font-size: 24px;
            }
            .shop-info {
                margin-top: 20px;
                font-size: 14px;
                color: #555;
            }
            .add-to-cart {
                margin-top: 20px;
            }
            .add-to-cart button {
                padding: 10px 15px;
                background-color: #00bfa5;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .add-to-cart button:hover {
                background-color: #009b8a;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2><?php echo htmlspecialchars($product['productName']); ?></h2>
            <img src="uploads/<?php echo htmlspecialchars($product['productPhoto']); ?>" alt="<?php echo htmlspecialchars($product['productName']); ?>"/>
            <p><?php echo nl2br(htmlspecialchars($product['productDesc'])); ?></p>
            <p class="price">Rp. <?php echo number_format($product['productPrice'], 0, ',', '.'); ?></p>
            <div class="shop-info">
                <small>Kategori: <?php echo htmlspecialchars($product['productCategory']); ?></small><br>
                <small>Toko: <?php echo htmlspecialchars($product['shopName']); ?> (<?php echo htmlspecialchars($product['city']); ?>)</small>
            </div>
            <div class="add-to-cart">
                <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="productId" value="<?php echo $product['productId']; ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "<p>Produk tidak ditemukan.</p>";
}

$conn->close();
?>