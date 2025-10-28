<?php
session_start();
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

// Cek apakah form telah dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $transactionId = $_POST['transactionId']; // ID Transaksi dari form
    $userId = $_SESSION['userId']; // User ID dari session

    // Cek apakah file diunggah
    if (isset($_FILES['paymentProof']) && $_FILES['paymentProof']['error'] == 0) {
        $fileName = $_FILES['paymentProof']['name'];
        $fileTmp = $_FILES['paymentProof']['tmp_name'];
        $fileSize = $_FILES['paymentProof']['size'];
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];

        // Validasi tipe file
        if (!in_array(strtolower($fileType), $allowedTypes)) {
            echo "Invalid file type. Only JPG, JPEG, PNG, and PDF are allowed.";
            exit();
        }

        // Validasi ukuran file (max 5MB)
        if ($fileSize > 5 * 1024 * 1024) {
            echo "File size exceeds 5MB.";
            exit();
        }

        // Buat nama file unik
        $newFileName = uniqid() . '.' . $fileType;

        // Pindahkan file ke folder tujuan
        $uploadDir = "uploads/payment_proofs/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filePath = $uploadDir . $newFileName;
        if (move_uploaded_file($fileTmp, $filePath)) {
            // Simpan data ke database
            $sql = "INSERT INTO payment_proofs (transactionId, userId, filePath, uploadDate) 
                    VALUES ('$transactionId', '$userId', '$filePath', NOW())";

            if ($conn->query($sql) === TRUE) {
                // Perbarui status transaksi
                $updateSql = "UPDATE transactions SET status = 'Payment Uploaded' WHERE transactionId = '$transactionId'";
                $conn->query($updateSql);

                echo "Payment proof uploaded successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Failed to upload file.";
        }
    } else {
        echo "No file uploaded or upload error.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Payment Proof</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        input[type="text"], input[type="file"], button {
            padding: 10px;
            font-size: 1em;
        }
        button {
            background-color: #5cb85c;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload Payment Proof</h2>
        <form action="upload_payment.php" method="POST" enctype="multipart/form-data">
            <label for="transactionId">Transaction ID:</label>
            <input type="text" id="transactionId" name="transactionId" placeholder="Enter your Transaction ID" required>

            <label for="paymentProof">Upload Proof:</label>
            <input type="file" id="paymentProof" name="paymentProof" accept=".jpg, .jpeg, .png, .pdf" required>

            <button type="submit">Upload Payment</button>
        </form>
    </div>
</body>
</html>

