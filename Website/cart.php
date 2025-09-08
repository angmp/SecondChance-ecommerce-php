<?php
session_start(); 
include 'header.php'; 

// Koneksi ke database
$servername = "localhost"; 
$username = "root"; 
$password = "";
$dbname = "sc_db"; 

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil userId dari session
$userId = $_SESSION['userId']; 

// Ambil data dari tabel cart dan join dengan tabel product dan shop
$sql = "SELECT c.*, p.productName, p.productPrice, p.productPhoto, p.shopId, s.shopName, s.bankAcc
        FROM cart c 
        JOIN product p ON c.productId = p.productId
        JOIN shop s ON p.shopId = s.shopId
        WHERE c.userId = '$userId'
        ORDER BY s.shopName, c.addedTime DESC";
$result = $conn->query($sql);

// Periksa jika query gagal
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Hitung subtotal
$subtotal = 0;
$cartItems = [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
        }
        .cart-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .order-summary {
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
.cart-item img {
    width: 80px; 
    height: 80px;
    object-fit: cover; 
    border-radius: 8px;
    margin-right: 15px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2); 
}

        .cart-item-details {
            flex: 1;
        }
        .cart-item-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        .cart-item-actions button {
            background-color: transparent;
            border: none;
            cursor: pointer;
            color: #ff4d4d;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .cart-item-actions button:hover {
            color: #ff1a1a;
        }
        .order-summary h3 {
            margin-top: 0;
        }
        .order-summary p {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        .order-summary button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .order-summary button:hover {
            background-color: #218838;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .order-summary {
                margin-left: 0;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    $currentShopId = null;
    $currentStoreName = '';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Jika shopId berubah, tampilkan nama toko baru
            if ($row['shopId'] != $currentShopId) {
                // Tutup section toko sebelumnya
                if ($currentShopId !== null) {
                    echo '</div>'; // Tutup div cart-section sebelumnya
                }
                $currentShopId = $row['shopId'];
                $currentStoreName = $row['shopName'];

                // Tampilkan nama toko
                echo "<h3>Store: " . htmlspecialchars($currentStoreName) . "</h3>";
                echo '<div class="cart-section">'; // Buka div baru untuk cart-section
            }

            echo '<div class="cart-item">';
            echo '<img src="uploads/' . htmlspecialchars($row['productPhoto']) . '" alt="' . htmlspecialchars($row['productName']) . '" width="80" height="80">';
            echo '<div class="cart-item-details">';
            echo '<p><strong>' . htmlspecialchars($row['productName']) . '</strong></p>'; 
            echo '<p>Harga: Rp ' . number_format($row['productPrice'], 2, ',', '.') . '</p>'; 
            echo '<p>Quantity: ' . $row['quantity'] . '</p>'; 
            echo '</div>'; // Tutup div cart-item-details
            
            // Checkbox untuk item
            ?>
                <input type="checkbox" 
                       class="item-checkbox" 
                       data-price="<?php echo $row['productPrice']; ?>" 
                       data-quantity="<?php echo $row['quantity']; ?>" 
                       data-shop-id="<?php echo $row['shopId']; ?>" 
                       data-bank-account="<?php echo $row['bankAcc']; ?>" 
                       data-product-id="<?php echo $row['productId']; ?>" 
                       data-product-name="<?php echo htmlspecialchars($row['productName']); ?>" />
            <?php
            echo '</div>'; // Tutup div cart-item
            
            // Tampilkan tombol aksi
            echo '<div class="cart-item-actions">';
            echo '<button><i class="fas fa-heart"></i></button>';

            // Tambahkan form untuk menghapus item
            echo '<form action="remove_from_cart.php" method="POST" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus produk ini?\');">';
            echo '<input type="hidden" name="cartId" value="' . htmlspecialchars($row['cartId']) . '">';
            echo '<button type="submit" style="color: #ff4d4d;"><i class="fas fa-trash"></i></button>';
            echo '</form>';
            echo '</div>'; // Tutup div cart-item-actions
        }

        // Tutup div cart-section terakhir jika ada
        if ($currentShopId !== null) {
            echo '</div>'; // Tutup div cart-section terakhir
        }
    } else {
        echo '<p>Keranjang belanja Anda kosong.</p>';
    }
    ?>
</div>

        </div> <!-- End of last cart section -->
        <div class="order-summary">
            <h3>Your Orders</h3>
            <p>
                <span>Subtotal</span>
                <span id="subtotal">Rp 0.00</span>
            </p>
            <p>
                <span>Shipping Cost</span>
                <span>Rp 5,000</span>
            </p>
            <p>
                <strong>
                    <span>Total</span>
                    <span id="total">Rp 5,000</span>
                </strong>
            </p>
            <!-- Form untuk Checkout -->
            <form action="process_checkout.php" method="POST" id="checkoutForm">
                <input type="hidden" name="subtotal" id="hiddenSubtotal" value="0">
                <input type="hidden" name="shipping_cost" value="5000"> <!-- Biaya pengiriman -->
                <input type="hidden" name="total" id="hiddenTotal" value="5000">
                <button type="submit" id="checkoutBtn">Checkout</button>
            </form>
        </div>
    </div>
<!-- Modal untuk upload pembayaran -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Upload Pembayaran</h3>
        <div id="modalProductList"></div> <!-- Daftar produk yang dipilih -->
        <p id="modalBankAccount"></p> <!-- Menampilkan nomor rekening bank -->
        <form action="process_payment.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="shopId" id="modalShopId">
            <input type="hidden" name="productIds" id="modalProductIds">
            <input type="hidden" name="totalAmount" id="modalTotalAmount">
            
            <p>Upload Bukti Pembayaran:</p>
            <input type="file" name="paymentProof" required><br><br>
            
            <button type="submit">Kirim</button>
        </form>
    </div>
</div>

<style>
    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border-radius: 8px;
        width: 60%;
    }

    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        right: 10px;
        top: 10px;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<script>
    // Menghitung subtotal dan total berdasarkan checkbox yang dicentang
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const subtotalElement = document.getElementById('subtotal');
    const totalElement = document.getElementById('total');
    const hiddenSubtotal = document.getElementById('hiddenSubtotal');
    const hiddenTotal = document.getElementById('hiddenTotal');
    const shippingCost = 5000;

    let selectedShopId = null; // Menyimpan ID toko yang dipilih

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const currentShopId = checkbox.getAttribute('data-shop-id');

            if (checkbox.checked) {
                // Jika checkbox dicentang, periksa apakah ada toko yang sudah dipilih
                if (selectedShopId === null) {
                    selectedShopId = currentShopId; // Set ID toko yang dipilih
                } else if (selectedShopId !== currentShopId) {
                    // Jika ID toko berbeda, tampilkan alert dan kembalikan checkbox ke tidak dicentang
                    alert('Anda tidak dapat mencentang produk dari toko yang berbeda!');
                    checkbox.checked = false; // Kembalikan checkbox ke tidak dicentang
                    return; // Keluar dari fungsi
                }
            } else {
                // Jika checkbox tidak dicentang, periksa apakah semua checkbox dicentang
                const allUnchecked = Array.from(checkboxes).every(cb => !cb.checked);
                if (allUnchecked) {
                    selectedShopId = null; // Reset ID toko jika tidak ada yang dicentang
                }
            }

                       // Hitung subtotal
                       let subtotal = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    const price = parseFloat(cb.getAttribute('data-price'));
                    const quantity = parseInt(cb.getAttribute('data-quantity'));
                    subtotal += price * quantity; // Hitung subtotal untuk item yang dicentang
                }
            });

            // Update elemen subtotal dan total
            subtotalElement.textContent = 'Rp ' + subtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&.');
            const total = subtotal + shippingCost;
            totalElement.textContent = 'Rp ' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&.');

            // Update hidden inputs untuk form checkout
            hiddenSubtotal.value = subtotal.toFixed(2);
            hiddenTotal.value = total.toFixed(2);
        });
    });

    document.getElementById('checkoutBtn').addEventListener('click', function(e) {
        e.preventDefault();  // Mencegah form untuk dikirimkan langsung

        // Dapatkan produk yang dipilih
        let selectedProductIds = [];
        let selectedShopId = null;
        let totalAmount = 0;
        let selectedProductsHtml = '';
        let bankAccount = ''; // Menyimpan nomor rekening bank

        document.querySelectorAll('.item-checkbox').forEach(function(checkbox) {
            if (checkbox.checked) {
                selectedProductIds.push(checkbox.getAttribute('data-product-id'));
                totalAmount += parseFloat(checkbox.getAttribute('data-price')) * parseInt(checkbox.getAttribute('data-quantity'));
                if (selectedShopId === null) {
                    selectedShopId = checkbox.getAttribute('data-shop-id');
                    bankAccount = checkbox.getAttribute('data-bank-account'); // Ambil nomor rekening bank
                } else if (selectedShopId !== checkbox.getAttribute('data-shop-id')) {
                    alert('Anda hanya bisa checkout produk dari satu toko!');
                    return;  // Keluar jika ada produk dari toko yang berbeda
                }

                // Menampilkan produk yang dipilih di modal
                selectedProductsHtml += `<p>${checkbox.getAttribute('data-product-name')} - Rp ${parseFloat(checkbox.getAttribute('data-price')).toFixed(2)}</p>`;
            }
        });

        if (selectedProductIds.length === 0) {
            alert('Silakan pilih produk terlebih dahulu.');
            return;
        }

        // Set data untuk modal
        document.getElementById('modalShopId').value = selectedShopId;
        document.getElementById('modalProductIds').value = selectedProductIds.join(',');
        document.getElementById('modalTotalAmount').value = totalAmount.toFixed(2);
        document.getElementById('modalBankAccount').textContent = `Nomor Rekening: ${bankAccount}`; // Tampilkan nomor rekening bank

        // Menampilkan produk yang dipilih dalam modal
        document.getElementById('modalProductList').innerHTML = selectedProductsHtml;

        // Tampilkan modal
        document.getElementById('paymentModal').style.display = "block";
    });

    // Fungsi untuk menutup modal
    function closeModal() {
        document.getElementById('paymentModal').style.display = "none";
    }

    document.querySelector('form[action="process_payment.php"]').addEventListener('submit', function(e) {
        const paymentProof = document.querySelector('input[name="paymentProof"]');
        
        if (!paymentProof.value) {
            alert("Harap upload bukti pembayaran!");
            e.preventDefault(); // Mencegah form untuk dikirimkan jika tidak ada bukti pembayaran
        }
    });
</script>

<?php
$conn->close(); // Menutup koneksi database
?>