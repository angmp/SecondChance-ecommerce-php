<?php
session_start();

include 'db_connect.php'; 

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['userId'])) {
    echo "<p class='error'>Harap login terlebih dahulu untuk mendaftar sebagai seller. <a href='user_login.php'>Login di sini</a>.</p>";
    exit;
}

// PHP untuk menangani registrasi seller
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['userId']; 
    $shopName = $_POST['shopName'];
    $shopDesc = $_POST['shopDesc'];
    $phoneNumber = $_POST['phoneNumber'];
    $city = $_POST['city'];
    $bankAccount = $_POST['bankAccount'];
    $paymentLink = $_POST['paymentLink'];  

    // Ambil email dari tabel user_data berdasarkan userId
    $emailQuery = "SELECT email FROM user_data WHERE userId = ?";
    $stmt = $conn->prepare($emailQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($userEmail);
    $stmt->fetch();
    $stmt->close();

    // Validasi input
    if (empty($shopName) || empty($phoneNumber) || empty($bankAccount)) {
        echo "<p class='error'>Nama toko, nomor telepon, dan nomor rekening bank tidak boleh kosong.</p>";
    } else {
        // SQL untuk memasukkan data toko ke dalam tabel shop
        $insertQuery = "INSERT INTO shop (userEmail, userId, shopName, phoneNumber, shopDesc, bankAcc, linkPayment, city) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sissssss", $userEmail, $userId, $shopName, $phoneNumber, $shopDesc, $bankAccount, $paymentLink, $city);

        if ($stmt->execute()) {
            echo "<p class='success'>Pendaftaran toko berhasil! Anda sekarang menjadi seller.</p>";

            // Perbarui kolom is_seller di tabel user_data
            $updateStmt = $conn->prepare("UPDATE user_data SET is_seller = 1 WHERE userId = ?");
            $updateStmt->bind_param("i", $userId);

            if ($updateStmt->execute()) {
                echo "<p class='success'>Status seller di tabel user diperbarui.</p>";
            } else {
                echo "<p class='error'>Gagal memperbarui status seller di tabel user.</p>";
            }

            $updateStmt->close();
        } else {
            echo "<p class='error'>Terjadi kesalahan, coba lagi.</p>";
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!-- Form Registrasi Seller -->
<div class="container">
    <div class="form-container">
    <div style="text-align: left; margin-bottom: 15px;">
    <a href="profile_cust.php" style="text-decoration: none; color: #24888b; font-weight: bold;">
        ← Kembali ke Dashboard
    </a>
</div>
        <h2>Registrasi Seller Center</h2>
        <form action="" method="POST">
            <label for="shopName">Nama Toko:</label>
            <input type="text" id="shopName" name="shopName" placeholder="Masukkan nama toko Anda" required>

            <label for="shopDesc">Deskripsi Toko:</label>
            <textarea id="shopDesc" name="shopDesc" placeholder="Deskripsikan toko Anda"></textarea>

            <label for="phoneNumber">Nomor Telepon:</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="Masukkan nomor telepon Anda" required>

            <label for="city">Kota/Kabupaten:</label>
            <select id="city" name="city" required>
                <option value="">Pilih Kota/Kabupaten</option>
                <option value="Jakarta Pusat">Jakarta Pusat</option>
                <option value="Jakarta Utara">Jakarta Utara</option>
                <option value="Jakarta Barat">Jakarta Barat</option>
                <option value="Jakarta Selatan">Jakarta Selatan</option>
                <option value="Jakarta Timur">Jakarta Timur</option>
                <option value="Bogor">Bogor</option>
                <option value="Depok">Depok</option>
                <option value="Tangerang">Tangerang</option>
                <option value="Tangerang Selatan">Tangerang Selatan</option>
                <option value="Bekasi">Bekasi</option>
                <option value="Kota Bogor">Kota Bogor</option>
                <option value="Kota Depok">Kota Depok</option>
                <option value="Kota Tangerang">Kota Tangerang</option>
                <option value="Kota Tangerang Selatan">Kota Tangerang Selatan</option>
                <option value="Kota Bekasi">Kota Bekasi</option>

            <label for="bankAccount">No Rekenig Bank:</label>
            <input type="text" id="bankAccount" name="bankAccount" placeholder="Masukkan nomor rekening bank Anda" required>
            <label for="paymentLink">Link Pembayaran:(optional)</label>
            <input type="url" id="paymentLink" name="paymentLink" placeholder="Masukkan link pembayaran (misal: e-wallet, link pembayaran)">

            </select>

            <p>Sudah memiliki akun? <a href="seller_login.php">Login di sini</a></p>

            <button type="submit">Daftar sebagai Seller</button>
        </form>
    </div>
</div>


<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #e9ecef;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        transition: transform 0.2s;
    }

    .container:hover {
        transform: scale(1.02);
    }

    .form-container {
        text-align: center;
    }

    h2 {
        color: #24888b;
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
    }

    label {
        display: block;
        margin: 15px 0 5px;
        color: #333;
        font-weight: 600;
        text-align: left;
    }

    input, textarea, select {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px; 
        border: 2px solid #ccc; 
        border-radius: 8px; 
        font-size: 16px; 
        box-sizing: border-box; 
        transition: border-color 0.3s, box-shadow 0.3s; 
    }

    input:focus, textarea:focus, select:focus {
        border-color: #45B4B1; 
        box-shadow: 0 0 8px rgba(69, 180, 177, 0.4); 
        outline: none;
    }


    button {
        background-color: #24888b;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s, transform 0.2s;
    }

    button:hover {
        background-color: #ff69b4;
        transform: translateY(-2px);
    }

    .success {
        color: green;
        text-align: center;
        margin-top: 20px;
        font-weight: bold;
    }

    .error {
        color: red;
        text-align: center;
        margin-top: 20px;
        font-weight: bold;
    }

    .shop-card {
        background: #f1f1f1;
        border-radius: 8px;
        padding: 15px;
        margin: 10px 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .shop-card h3 {
        color: #24888b;
        margin: 0 0 10px;
    }

    .shop-card p {
        margin: 5px 0;
        color: #555;
    }
</style>

<?php
include 'footer.php'; // Tambahkan footer jika ada
?>
