<?php
// Ambil data koneksi dari environment Railway
$servername = getenv("MYSQLHOST");
$username   = getenv("MYSQLUSER");
$password   = getenv("MYSQLPASSWORD");
$dbname     = getenv("MYSQLDATABASE");
$port       = getenv("MYSQLPORT"); // optional, tapi disarankan

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>




