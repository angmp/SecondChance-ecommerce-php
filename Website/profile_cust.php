<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: user_login.php'); 
    exit();
}

// Include database connection
include 'db_connect.php';

// Fetch user data from the database
$userId = $_SESSION['userId'];
$stmt = $conn->prepare("SELECT first_name, last_name, email, gender FROM user_data WHERE userId = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Second Chance - Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .profile-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-info h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 600;
        }

        .profile-info p {
            margin: 10px 0;
        }

        .btn {
            background-color: #45B4B1;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #3a9b8e;
        }
    </style>
</head>
<?php include 'header.php'; ?>
<main class="container mx-auto px-4 py-8">
    <div class="flex space-x-8">
        <aside class="w-1/4 bg-white p-4 rounded-lg shadow-sm">
            <nav>
                <ul class="space-y-4" id="menu">
                    <li>
                        <a href="profile_cust.php" class="flex items-center space-x-2 text-teal-500 border border-gray-300 rounded-lg p-2">
                            <i class="fas fa-th-large"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="order_history.php" class="flex items-center space-x-2 text-gray-700 p-2">
                            <i class="fas fa-history"></i>
                            <span>Order History</span>
                        </a>
                    </li>
                    <li>
                        <a href="cart.php" class="flex items-center space-x-2 text-gray-700 p-2">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Shopping Cart</span>
                        </a>
                    </li>
                    <li>
                        <a href="seller_registrasi.php" class="flex items-center space-x-2 text-gray-700 p-2">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Seller Center</span>
                        </a>
                    </li>
                    <li>
    <a href="logout_user.php" class="flex items-center space-x-2 text-gray-700 p-2">
        <i class="fas fa-sign-out-alt"></i>
        <span>Log-out</span>
    </a>
</li>
                </ul>
            </nav>
        </aside>
        <section class="w-3/4 flex space-x-8">
            <div class ="profile-info w-full">
                <h2>Profile Information</h2>
                <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['first_name']); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['last_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
                <a href="profile_cust_edit.php" class="btn">Edit Profile</a>
            </div>
        </section>
    </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>