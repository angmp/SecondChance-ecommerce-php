<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $total = $_POST['total'];

    $query = mysqli_query($koneksi, "INSERT INTO transaksi (nama, alamat, total) VALUES ('$nama', '$alamat', '$total')");
    
    if ($query) {
        $transaksi_id = mysqli_insert_id($koneksi);
        
        foreach ($_SESSION['cart'] as $item) {
            $produk_id = $item['id'];
            $jumlah = $item['quantity'];
            $harga = $item['price'];
            
            mysqli_query($koneksi, "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, harga) VALUES ('$transaksi_id', '$produk_id', '$jumlah', '$harga')");
        }
        
        unset($_SESSION['cart']);
        
        header("Location: success.php");
        exit();
    } else {
        echo "Terjadi kesalahan saat memproses transaksi.";
    }
}
?>