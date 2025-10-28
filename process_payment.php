<?php
session_start();

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sc_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil userId dari session
$userId = $_SESSION['userId']; 

// Cek apakah totalAmount ada dan merupakan angka
$totalAmount = isset($_POST['totalAmount']) ? floatval($_POST['totalAmount']) : 0; // Ambil total pembayaran dari form atau cart

// Cek apakah cartId ada dan merupakan array
if (isset($_POST['cartId']) && is_array($_POST['cartId']) && count($_POST['cartId']) > 0) {
    $cartItems = $_POST['cartId']; // Ambil data item yang dibeli dari form atau cart

    // 1. Menyimpan transaksi
    $transactionStmt = $conn->prepare("INSERT INTO transactions (userId, totalAmount, transactionDate, status) VALUES (?, ?, NOW(), 'Pending')");
    $transactionStmt->bind_param("id", $userId, $totalAmount);
    if ($transactionStmt->execute()) {
        $transactionId = $conn->insert_id; // Mendapatkan ID transaksi yang baru disimpan

        // 2. Menyimpan detail transaksi
        foreach ($cartItems as $item) {
            $productId = $item['productId'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            // Menyimpan ke tabel transaction_details
            $detailStmt = $conn->prepare("INSERT INTO transaction_details (transactionId, productId, quantity, price) VALUES (?, ?, ?, ?)");
            $detailStmt->bind_param("iiid", $transactionId, $productId, $quantity, $price);
            $detailStmt->execute();

            // Mengurangi stok produk di database
            $updateStockStmt = $conn->prepare("UPDATE product SET quantity = quantity - ? WHERE productId = ?");
            $updateStockStmt->bind_param("ii", $quantity, $productId);
            $updateStockStmt->execute();
        }

        // 3. Menyimpan bukti pembayaran
        if ($_FILES['paymentProof']['error'] === UPLOAD_ERR_OK) {
            // Memeriksa jika file bukti pembayaran di-upload
            $fileTmpPath = $_FILES['paymentProof']['tmp_name'];
            $fileName = $_FILES['paymentProof']['name'];

            // Menentukan direktori penyimpanan file
            $uploadDir = 'uploads/payment_proofs/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Membuat folder jika belum ada
            }

            // Memindahkan file ke folder tujuan
            $destination = $uploadDir . basename($fileName);
            if (move_uploaded_file($fileTmpPath, $destination)) {
                // Simpan bukti pembayaran ke tabel transaction_payment
                $paymentStmt = $conn->prepare("INSERT INTO transaction_payment (transactionId, userId, filePath, uploadDate) VALUES (?, ?, ?, NOW())");
                $paymentStmt->bind_param("iis", $transactionId, $userId, $destination);
                $paymentStmt->execute();

                // 4. Update status transaksi menjadi "Pending" atau "Awaiting Confirmation"
                $updateStatusStmt = $conn->prepare("UPDATE transactions SET status = 'Pending' WHERE transactionId = ?");
                $updateStatusStmt->bind_param("i", $transactionId);
                $updateStatusStmt->execute();

                // 6. Menghapus item dari keranjang setelah pembayaran
                $deleteCartStmt = $conn->prepare("DELETE FROM cart WHERE userId = ?");
                $deleteCartStmt->bind_param("i", $userId);
                $deleteCartStmt->execute();

                echo "Pembayaran berhasil di-upload. Status transaksi: Pending";
            } else {
                echo "Gagal meng-upload bukti pembayaran.";
            }
        } else {
            echo "Harap upload bukti pembayaran.";
        }
    } else {
        echo "Gagal menyimpan transaksi. Silakan coba lagi.";
    }
} else {
    echo "Tidak ada data cartId yang diterima atau cartId kosong.";
}
var_dump($_POST);
exit; // Hentikan eksekusi untuk melihat output
// 5. Menutup koneksi database
$conn->close();
?>