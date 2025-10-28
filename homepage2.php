<?php
session_start(); 

include 'header.php';

// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = ''; 
$database = 'sc_db';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Periksa apakah userId ada di session
if (!isset($_SESSION['userId'])) {
    echo "<p class='error'>Anda harus login untuk melihat produk. <a href='user_login.php'>Login di sini</a></p>";
    exit;
}

$userId = $_SESSION['userId']; // Ambil userId dari session

// Sort order handling
$sort_order = '';
if (isset($_GET['sort_price'])) {
    if ($_GET['sort_price'] == 'asc') {
        $sort_order = 'ORDER BY p.productPrice ASC';
    } elseif ($_GET['sort_price'] == 'desc') {
        $sort_order = 'ORDER BY p.productPrice DESC';
    }
}

// Search functionality
$search = isset($_POST['search']) ? $_POST['search'] : '';
$searchTerm = '%' . $search . '%';

// SQL untuk mengambil data produk
$sql = "SELECT p.productId, p.productName, p.productDesc, p.productCategory, p.productPrice, p.productPhoto, p.created_at, s.shopId, s.shopName, s.city, p.productQuantity
        FROM product p
        JOIN shop s ON p.shopId = s.shopId  
        WHERE p.productName LIKE ? OR p.productDesc LIKE ? $sort_order";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style_catalog.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h3>Sort by Price</h3>
            <form method="GET" action="">
                <label><input type="radio" name="sort_price" value="asc" <?php echo (isset($_GET['sort_price']) && $_GET['sort_price'] == 'asc') ? 'checked' : ''; ?> /> Lowest - Highest Price</label>
                <label><input type="radio" name="sort_price" value="desc" <?php echo (isset($_GET['sort_price']) && $_GET['sort_price'] == 'desc') ? 'checked' : ''; ?> /> Highest - Lowest Price</label>
                <button type="submit">Sort</button>
            </form>

            <h3>Term of Use</h3>
            <label><input type="checkbox"/> Brand New</label>
            <label><input type="checkbox"/> Like New</label>
            <label><input type="checkbox"/> Lightly Used</label>
            <label><input type="checkbox"/> Often Used</label>
            <label><input type="checkbox"/> Old Stuff</label>
        </div>

        <div class="products">
            <h2>Available Products</h2>

            <!-- Search Form -->
            <form method="POST" action="">
                <input type="text" name="search" placeholder="Search by name or description" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
                <button type="submit">Search</button>
            </form>
            <div class="product-grid">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="product-card" onclick="showModal(<?= $row['productId'] ?>)">
                            <img src="uploads/<?= htmlspecialchars($row['productPhoto']) ?>" alt="<?= htmlspecialchars($row['productName']) ?>">
                            <div class="content">
                                <h3><?= htmlspecialchars($row['productName']) ?></h3>
                                <p><?= htmlspecialchars($row['productDesc']) ?></p>
                                <p class="price">Rp<?= number_format($row['productPrice'], 2, ',', '.') ?></p>
                                <small>Stok Tersedia: <?= htmlspecialchars($row['productQuantity']) ?></small>
                                <small>Kategori: <?= htmlspecialchars($row['productCategory']) ?></small>
                                
                                <?php if (isset($row['shopId'], $row['shopName'], $row['city'])): ?>
                                    <small>Toko: <a href="shop.php?shopId=<?= htmlspecialchars($row['shopId']) ?>"><?= htmlspecialchars($row['shopName']) ?></a> (<?= htmlspecialchars($row['city']) ?>)</small>
                                <?php else: ?>
                                    <small>Toko: Tidak tersedia</small>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Tidak ada produk yang tersedia.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <div id="modalProductDetails"></div>
        </div>
    </div>

    <script>
        function showModal(productId) {
            // Fetch the product details using AJAX
            fetch('get_product_detail.php?productId=' + productId)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('modalProductDetails').innerHTML = data;
                    document.getElementById('productModal').style.display = 'block';
                })
                .catch(error => console.error('Error:', error));
        }

        function closeModal() {
            document.getElementById('productModal').style.display = 'none';
        }
    </script>

<?php
include 'footer.php';
$conn->close();
?>
</body>
</html>