<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    header("Location: user_login.php");
    exit();
}

// Check if shopId is set in session
if (!isset($_SESSION['shopId'])) {
    echo '<script>alert("Shop ID is not set. Please log in to a shop.");</script>';
    header("Location: user_login.php");
    exit();
}

$userId = $_SESSION['userId']; 
$shopId = $_SESSION['shopId']; 

// Connect to the database
$host = 'localhost';
$dbname = 'sc_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to database: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['productPhoto'])) {
        // Debugging: Check if file data is correctly received
        if ($_FILES['productPhoto']['error'] === UPLOAD_ERR_OK) {
            $productName = htmlspecialchars($_POST['productName'] ?? '');
            $productDesc = htmlspecialchars($_POST['productDesc'] ?? null); // Nullable
            $productCategory = htmlspecialchars($_POST['productCategory'] ?? null); // Nullable
            $productPrice = filter_var($_POST['productPrice'] ?? null, FILTER_VALIDATE_FLOAT);
            $productQuantity = filter_var($_POST['productQuantity'] ?? null, FILTER_VALIDATE_INT);
            $createdAt = date('Y-m-d H:i:s');

            // Handle file upload
            $productPhoto = null;
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $fileName = basename($_FILES['productPhoto']['name']);
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array(strtolower($fileExt), $allowedExts)) {
                $productPhoto = uniqid() . "_" . $fileName;
                $targetFilePath = $targetDir . $productPhoto;

                if (move_uploaded_file($_FILES['productPhoto']['tmp_name'], $targetFilePath)) {
                    try {
                        $stmt_check = $pdo->prepare("SELECT userId FROM user_data WHERE userId = :userId");
                        $stmt_check->bindParam(':userId', $userId, PDO::PARAM_INT);
                        $stmt_check->execute();

                        if ($stmt_check->rowCount() === 0) {
                            echo '<script>alert("User ID not found in user_data.");</script>';
                            exit();
                        }

                        // Insert product into database including shopId
                        $sql = "INSERT INTO product (userId, shopId, productName, productDesc, productCategory, productPrice, productQuantity, productPhoto, created_at) 
                                VALUES (:userId, :shopId, :productName, :productDesc, :productCategory, :productPrice, :productQuantity, :productPhoto, :created_at)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
                            ':userId' => $userId,
                            ':shopId' => $shopId, 
                            ':productName' => $productName,
                            ':productDesc' => $productDesc,
                            ':productCategory' => $productCategory,
                            ':productPrice' => $productPrice,
                            ':productQuantity' => $productQuantity,
                            ':productPhoto' => $productPhoto,
                            ':created_at' => $createdAt
                        ]);

                        echo '<script>alert("Product added successfully.");</script>';
                    } catch (PDOException $e) {
                        if ($e->getCode() == 23000) {
                            echo '<script>alert("Foreign key constraint violation. Please ensure referenced data exists.");</script>';
                        } else {
                            echo '<script>alert("Database error: ' . $e->getMessage() . '");</script>';
                        }
                    }
                } else {
                    echo '<script>alert("Error moving the uploaded file.");</script>';
                }
            } else {
                echo '<script>alert("Invalid file type.");</script>';
            }
        } else {
            echo '<script>alert("Error uploading file. Please try again.");</script>';
        }
    } else {
        echo '<script>alert("No file uploaded.");</script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
        }

        .nav-links {
            display: flex;
            justify-content: center;
            background-color: #FBFFE9;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: #EF7FBF;
            margin-right: 20px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-links a:hover {
            background-color: #e6f7f7;
        }

        .nav-links a.active {
            background-color: #b3e4e4;
            color: #000;
        }

        nav {
            width: 220px;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            margin-bottom: 15px;
        }

        nav ul li a {
            display: block;
            text-decoration: none;
            color: #333;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        nav ul li a:hover, nav ul li a.active {
            background-color: #CBF2F1;
            color: black;
        }
        
        .container {
            display: flex;
            margin: 20px auto;
            max-width: 1200px;
        }
        .form-container {
            display: flex;
            flex: 1;
            gap: 20px;
        }
        .form-left, .form-right {
            flex: 1;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #fafafa;
        }
        .form-left img {
            max-width: 100%;
            max-height: 200px;
            margin-bottom: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            display: none;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #45B4B1;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<!-- Navigation Links -->
<div class="nav-links">
        <a href="seller_dashboard.php">Home</a>
        <a href="store.php">Store</a>
    </div>

<div class="container">
        <nav>
            <ul>
                <li><a href="seller_dashboard.php">Dashboard</a></li>
                <li><a href="add_product.php" class="active">Add Products</a></li>
                <li><a href="manage_product.php">Manage Products</a></li>
                <li><a href="logout.php">Log-out</a></li>
            </ul>
        </nav>

        <div class="form-container">
            <!-- Preview Image -->
            <div class="form-left">
                <h3>Upload Product Photo</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                <img id="productImagePreview" src="#" alt="Preview">
                <input type="file" id="productPhoto" name="productPhoto" accept="image/*" onchange="previewImage()">
            </div>
           
<!-- Form to Add Product -->
<div class="form-right">
    <h2>Add Product</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" required>
        </div>
        <div class="form-group">
            <label for="productDesc">Product Description:</label>
            <input type="text" id="productDesc" name="productDesc">
        </div>
        <div class="form-group">
            <label for="productCategory">Product Category:</label>
            <select id="productCategory" name="productCategory" required>
                <option value="Shirts">Shirts</option>
                <option value="Pants">Pants</option>
                <option value="Sweaters & Hoodies">Sweaters & Hoodies</option>
                <option value="Accessories">Accessories</option>
                <option value="Footwear">Footwear</option>
            </select>
        </div>
        <div class="form-group">
            <label for="productPrice">Product Price:</label>
            <input type="number" id="productPrice" name="productPrice" required>
        </div>
        <div class="form-group">
            <label for="productQuantity">Product Quantity:</label>
            <input type="number" id="productQuantity" name="productQuantity" required>
        </div>
        <button type="submit">Add Product</button>
    </form>
</div>

        </div>
    </div>

    <script>
        function previewImage() {
            const productPhotoInput = document.getElementById('productPhoto');
            const productImagePreview = document.getElementById('productImagePreview');

            const file = productPhotoInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    productImagePreview.src = e.target.result;
                    productImagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                productImagePreview.style.display = 'none';
            }
        }
    </script>
</body>
</html>