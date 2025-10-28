<?php
session_start();
require 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cartId'])) {
    $cartId = intval($_POST['cartId']); 

    // Query untuk menghapus item dari keranjang
    $query = "DELETE FROM cart WHERE cartId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $cartId);

    if ($stmt->execute()) {
        // Jika berhasil, set session message
        $_SESSION['message'] = "Produk berhasil dihapus dari keranjang.";
        $_SESSION['message_type'] = "success";
    } else {
        // Jika gagal, set session message
        $_SESSION['message'] = "Gagal menghapus produk. Coba lagi.";
        $_SESSION['message_type'] = "error";
    }

    $stmt->close();
    $conn->close();

    // Redirect kembali ke halaman cart
    header("Location: cart.php");
    exit();
} else {
    $_SESSION['message'] = "Permintaan tidak valid.";
    $_SESSION['message_type'] = "error";
    header("Location: cart.php");
    exit();
}
?>


