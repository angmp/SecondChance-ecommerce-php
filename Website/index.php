<?php
include 'db_connect.php'; 

include 'header.php';

$sql = "SELECT p.productId, p.productName, p.productDesc, p.productCategory, p.productPrice, p.productPhoto, p.created_at, s.shopName, s.city 
        FROM product p
        JOIN shop s ON p.shopId = s.shopId  
        ORDER BY p.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Chance Clothing</title>
    <link rel="stylesheet" href="style_index.css"> 
</head>
<body>
<section class="homepage-section">
    <div class="homepage-box">
    <div class="homepage-content">
    <h1>Everything deserves a Second Chance, Even Clothing.</h1>
    <p>Discover sustainable fashion through preloved items and give clothes a second life.</p>
    <?php if (isset($_SESSION['userId'])): ?>
        <a href="user_profile.php" class="homepage-button">Profile</a>
    <?php else: ?>
        <a href="user_login.php" class="homepage-button">Sign Up</a>
    <?php endif; ?>
</div>
        <div class="homepage-image">
            <img src="uploads/homepage.png" alt="Sustainable Fashion">
        </div>
    </div>
</section>
<h2 class="fomo-title">Explore Our Product!</h2>
<div class="category-section">
    <div class="category-container">
        <div class="category-item">
            <a href="listing_shirts.php">
                <img src="uploads/ShirtIndex.jpg" alt="Shirts">
                <h2>Shirts</h2>
            </a>
        </div>
        <div class="category-item">
            <a href="listing_footwear.php">
                <img src="uploads/SepatuIndex.jpg" alt="Footwear">
                <h2>Footwear</h2>
            </a>
        </div>
        <div class="category-item">
            <a href="listing_pants-jeans.php">
                <img src="uploads/JeansIndex.jpg" alt="Pants">
                <h2>Pants</h2>
            </a>
        </div>
        <div class="category-item">
            <a href="listing_accessories.php">
                <img src="uploads/AccesIndex.jpg" alt="Accessories">
                <h2>Accessories</h2>
            </a>
        </div>
        <div class="category-item">
            <a href="listing_sweaters-hoodies.php">
                <img src="uploads/SweaterIndex.jpg" alt="Sweaters">
                <h2>Sweaters</h2>
            </a>
        </div>
    </div>
</div>
</section>

    <main>
        <h2 class="fomo-title">Anti Fomo-Fomo Club</h2>

        <section class="products">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product-card" onclick="showModal(<?= $row['productId'] ?>)">
                        <img src="uploads/<?= htmlspecialchars($row['productPhoto']) ?>" alt="<?= htmlspecialchars($row['productName']) ?>">
                        <div class="content">
                            <h3><?= htmlspecialchars($row['productName']) ?></h3>
                            <p><?= htmlspecialchars($row['productDesc']) ?></p>
                            <p class="price">Rp<?= number_format($row['productPrice'], 2, ',', '.') ?></p>
                            <small>Kategori: <?= htmlspecialchars($row['productCategory']) ?></small>
                            <small>Toko: <?= htmlspecialchars($row['shopName']) ?> (<?= htmlspecialchars($row['city']) ?>)</small>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Tidak ada produk yang tersedia.</p>
            <?php endif; ?>
        </section>

        <!-- Modal Structure -->
        <div id="productModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <div id="modalProductDetails"></div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

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
</body>
</html>

<?php
$conn->close(); 
?>