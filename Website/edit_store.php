<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

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

if (isset($_GET['id'])) {
    $shopId = $_GET['id'];

    // Ambil data toko berdasarkan shopId
    $sqlShop = "SELECT * FROM shop WHERE shopId = :shopId LIMIT 1";
    $stmtShop = $pdo->prepare($sqlShop);
    $stmtShop->execute(['shopId' => $shopId]);
    $shop = $stmtShop->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses pembaruan data toko
    $storeName = $_POST['store_name'];
    $openTime = $_POST['open_time'];
    $closeTime = $_POST['close_time'];

    // Gabungkan jam operasional
    $operationalHours = $openTime . " - " . $closeTime;

    // Update data toko
    $sqlUpdate = "UPDATE shop SET shopName = :storeName, operationalHours = :operationalHours WHERE shopId = :shopId";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->execute([
        'storeName' => $storeName,
        'operationalHours' => $operationalHours,
        'shopId' => $shopId
    ]);

    // Redirect back to store page with updated shopId
    header("Location: store.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Chance - Edit Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #444;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            margin-top: 8px;
            color: #333;
        }

        .form-group input:focus {
            outline: none;
            border-color: #44c8c0;
        }

        .form-buttons {
            display: flex;
            justify-content: space-between;
        }

        .form-buttons button {
            padding: 12px 20px;
            font-size: 16px;
            background-color: #44c8c0;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 48%;
        }

        .form-buttons button:hover {
            background-color: #36b1ad;
        }

        .form-buttons button:focus {
            outline: none;
        }

        .form-group .operational-hours {
            display: flex;
            justify-content: space-between;
        }

        .form-group .operational-hours input {
            width: 48%;
        }
    </style>
</head>
<body>

<!-- Formulir Edit Toko -->
<div class="container">
    <h2>Edit Store</h2>
    <form method="POST">
        <div class="form-group">
            <label for="store_name">Store Name:</label>
            <input type="text" name="store_name" id="store_name" value="<?php echo htmlspecialchars($shop['shopName']); ?>" required>
        </div>

        <div class="form-group">
            <label for="open_time">Open Time:</label>
            <input type="time" name="open_time" id="open_time" value="<?php echo substr($shop['operationalHours'], 0, 5); ?>" required>
        </div>

        <div class="form-group">
            <label for="close_time">Close Time:</label>
            <input type="time" name="close_time" id="close_time" value="<?php echo substr($shop['operationalHours'], 8, 5); ?>" required>
        </div>

        <div class="form-buttons">
            <button type="submit">Save</button>
        </div>
    </form>
</div>

</body>
</html>
