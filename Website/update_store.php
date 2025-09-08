<?php
include('db_connect.php'); // Menghubungkan ke database

// Memeriksa apakah data POST ada
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mendapatkan data dari formulir
    $shopId = $_POST['shopId']; 
    $storeName = $_POST['store_name'];
    $openTime = $_POST['open_time'];
    $closeTime = $_POST['close_time'];

    // Menggabungkan jam buka dan tutup menjadi satu string
    $operationalHours = $openTime . " - " . $closeTime;

    // Query untuk memperbarui data toko di database
    $sql = "UPDATE shop SET shopName = ?, operationalHours = ? WHERE shopId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $storeName, $operationalHours, $shopId);

    // Memeriksa apakah query berhasil dijalankan
    if ($stmt->execute()) {
        // Redirect ke halaman toko dengan ID yang sudah diperbarui
        header("Location: store.php?shopId=$shopId");
        exit();
    } else {
        // Menangani error jika query gagal
        echo "Error updating store: " . $stmt->error;
    }
} else {
    echo "Invalid request method.";
}
?>
