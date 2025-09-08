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
        ORDER BY s.shopName, c.addedTime DESC"; // Mengurutkan berdasarkan nama toko dan waktu ditambahkan
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Ambil informasi nomor rekening bank dari toko yang pertama kali dipilih
$row = $result->fetch_assoc();
$bankAcc = $row['bankAcc'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Checkout</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        
    </style>
</head>
<body>
    <div class="container">
        <h3>Your Orders</h3>
        <div class="cart-section">
            <?php
            if ($result->num_rows > 0) {
                // Menampilkan item dalam cart
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="cart-item">';
                    echo '<img alt="Image of ' . htmlspecialchars($row['productName']) . '" src="uploads/' . htmlspecialchars($row['productPhoto']) . '" width="80"/>';
                    echo '<div class="cart-item-details">';
                    echo '<h4>' . htmlspecialchars($row['productName']) . '</h4>';
                    echo '<p>Price: Rp ' . number_format($row['productPrice'], 2, ',', '.') . '</p>';
                    echo '<p>Quantity: ' . htmlspecialchars($row['quantity']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p>Your cart is empty.</p>";
            }
            ?>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <h3>Order Summary</h3>
            <p>Subtotal: Rp <span id="subtotal">0.00</span></p>
            <p>Shipping Cost: Rp 5,000</p>
            <p><strong>Total: Rp <span id="total">0.00</span></strong></p>

            <!-- Checkout Form -->
            <button id="checkoutBtn">Checkout</button>
        </div>

        <!-- Modal for Payment -->
        <div id="paymentModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h3>Upload Payment Proof</h3>
                <form action="process_payment.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="shopId" value="<?php echo $row['shopId']; ?>">
                    <input type="hidden" name="totalAmount" value="<?php echo $row['productPrice'] * $row['quantity']; ?>">

                    <!-- Tampilkan nomor rekening bank yang diambil dari database -->
                    <p>Bank Account Number: <span id="modalBankAcc"><?php echo htmlspecialchars($bankAcc); ?></span></p>

                    <p>Upload Payment Proof:</p>
                    <input type="file" name="paymentProof" required><br><br>

                    <p>Your Account Number:</p>
                    <input type="text" name="accountNumber" required><br><br>

                    <button type="submit">Submit Payment</button>
                </form>
            </div>
        </div>

    </div>

    <script>
        // Tampilkan modal ketika tombol checkout diklik
        document.getElementById('checkoutBtn').addEventListener('click', function() {
            document.getElementById('paymentModal').style.display = "block";
        });

        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById('paymentModal').style.display = "none";
        }
    </script>
</body>
</html>

<?php
$conn->close(); // Menutup koneksi database
?>
