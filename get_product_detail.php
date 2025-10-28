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
        FROM product p
        JOIN shop s ON p.shopId = s.shopId
        WHERE p.productId = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    ?>
    <h2><?= htmlspecialchars($product['productName']) ?></h2>
    <img src="uploads/<?= htmlspecialchars($product['productPhoto']) ?>" alt="<?= htmlspecialchars($product['productName']) ?>" style="width:100%; height:auto;">
    <p><?= htmlspecialchars($product['productDesc']) ?></p>
    <p class="price">Rp<?= number_format($product['productPrice'], 2, ',', '.') ?></p>
    <small>Kategori: <?= htmlspecialchars($product['productCategory']) ?></small>
    <small>Toko: <?= htmlspecialchars($product['shopName']) ?> (<?= htmlspecialchars($product['city']) ?>)</small>
    <form action="add_to_cart.php" method="POST">
    <input type="hidden" name="productId" value="<?php echo $productId; ?>"> <!-- productId yang dikirimkan -->
    <label for="productQuantity">Quantity:</label>
    <input type="number" name="quantity" value="1" min="1" required> <!-- quantity yang dikirimkan -->
    <button type="submit">Add to Cart</button>
</form>

    <?php
} else {
    echo "<p>Produk tidak ditemukan.</p>";
}

$conn->close();
?>
