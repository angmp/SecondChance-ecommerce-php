<?php
include 'header.php';
// Koneksi ke database
$host = 'localhost'; 
$dbname = 'sc_db'; 
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Ambil shopId dari URL
$shopId = isset($_GET['shopId']) ? $_GET['shopId'] : null;

if ($shopId) {
    // Ambil informasi shop berdasarkan shopId
    $sqlShop = "SELECT * FROM shop WHERE shopId = :shopId LIMIT 1";
    $stmtShop = $pdo->prepare($sqlShop);
    $stmtShop->execute(['shopId' => $shopId]);
    $shop = $stmtShop->fetch(PDO::FETCH_ASSOC);

    // Ambil produk dari tabel product yang terkait dengan shopId
    $sqlProducts = "SELECT * FROM product WHERE shopId = :shopId";
    $stmtProducts = $pdo->prepare($sqlProducts);
    $stmtProducts->execute(['shopId' => $shopId]);
    $products = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Jika shopId tidak ada, redirect atau tampilkan pesan error
    header("Location: error_page.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title><?php echo htmlspecialchars($shop['shopName']); ?></title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&amp;display=swap" rel="stylesheet"/>
  <style>
    body {
        font-family: 'Poppins', sans-serif;
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
    .container {
        display: flex;
        padding: 20px;
    }
    .main-content {
        width: 100%;
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
        box-shadow:         0 10px rgba(0, 0, 0, 0.1);
        height: 350px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer; 
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
    .main-content .products .product .stock {
        font-size: 12px;
        color: #888;
    }
    
    .modal {
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4); 
        padding-top: 60px;
    }
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto; 
        padding: 20px;
        border: 1px solid #888;
        width: 80%; 
        max-width: 600px;
        border-radius: 10px;
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
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
    
    /* Gaya untuk tombol Add to Cart */
    #addToCartButton {
        background-color: #00bfa5; 
        color: white; 
        border: none; 
        padding: 10px 15px; 
        border-radius: 5px; 
        cursor: pointer; 
        font-size: 16px;
        transition: background-color 0.3s; 
    }

    #addToCartButton:hover {
        background-color: #009b8a;
    }

    /* Modal Styles */
    .modal {
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }
    
  </style>
</head>
<body>

    <!-- Navigation Links -->
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="shop_list.php">Shop List</a>
    </div>

    <div class="container">
        <main class="main-content">
            <!-- Display Shop Info -->
            <div class="shop-info">
                <div class="details">
                    <div>
                        <h1><?php echo htmlspecialchars($shop['shopName']); ?></h1>
                        <div>
                            <i class="fas fa-box"></i> Products: <?php echo count($products); ?>
                            <i class="fas fa-star"></i> 5/5
                            <i class="fas fa-shopping-cart"></i> Sold 100
                            <i class="fas fa-share-alt"></i> Share
                            <i class="fas fa-clock"></i> 13.00 - 21.00
                        </div>
                    </div>
                </div>
            </div>

            <h2>All Products</h2>

            <!-- Display Products -->
            <div class="products">
                <?php foreach ($products as $product): ?>
                <div class="product" onclick="openModal(<?php echo $product['productId']; ?>)">
                    <img alt="<?php echo htmlspecialchars($product['productName']); ?>" src="uploads/<?php echo htmlspecialchars($product['productPhoto']); ?>" width="300" height="300"/>
                    <p><?php echo htmlspecialchars($product['productName']); ?></p>
                    <p class="price">Rp. <?php echo number_format($product['productPrice'], 0, ',', '.'); ?></p>
                    <p class="stock">Stok: <?php echo htmlspecialchars($product['productQuantity']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <!-- Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalProductName"></h2>
            <img id="modalProductImage" src="" alt="" style="max-width: 100%; border-radius: 5px;"/>
            <p id="modalProductDesc"></p>
            <p class="price" id="modalProductPrice"></p>
            <p class="stock" id="modalProductStock"></p>
            <button id="addToCartButton" onclick="addToCart()">Add to Cart</button>
        </div>
    </div>

    <script>
        // Data produk untuk modal
        const products = <?php echo json_encode($products); ?>;

        function openModal(productId) {
            const product = products.find(p => p.productId === productId);
            if (product) {
                document.getElementById('modalProductName').innerText = product.productName;
                document.getElementById('modalProductImage').src = 'uploads/' + product.productPhoto;
                document.getElementById('modalProductDesc').innerText = product.productDesc;
                document.getElementById('modalProductPrice').innerText = 'Rp. ' + new Intl.NumberFormat('id-ID').format(product.productPrice);
                document.getElementById('modalProductStock').innerText = 'Stok: ' + product.productQuantity;

                // Tampilkan modal
                document.getElementById('productModal').style.display = 'block';
                // Simpan ID produk di tombol
                document.getElementById('addToCartButton').setAttribute('data-product-id', productId);
            }
        }

        function closeModal() {
            document.getElementById('productModal').style.display = 'none';
        }

        function addToCart() {
            const productId = document.getElementById('addToCartButton').getAttribute('data-product-id');
            const product = products.find(p => p.productId === productId);

            if (product) {
                // Ambil keranjang dari sessionStorage
                let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
                
                // Cek apakah produk sudah ada di keranjang
                const existingProduct = cart.find(item => item.productId === productId);
                if (existingProduct) {
                    existingProduct.quantity += 1; 
                } else {
                    // Tambahkan produk baru ke keranjang
                    cart.push({
                        productId: product.productId,
                        productName: product.productName,
                        productPrice: product.productPrice,
                        quantity: 1
                    });
                }

                // Simpan kembali ke sessionStorage
                sessionStorage.setItem('cart', JSON.stringify(cart));
                alert('Produk telah ditambahkan ke keranjang!');
                closeModal(); 
            }
        }

        // Tutup modal jika pengguna mengklik di luar modal
        window.onclick = function(event) {
            const modal = document.getElementById('productModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>