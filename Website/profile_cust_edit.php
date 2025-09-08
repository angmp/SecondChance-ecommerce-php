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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update user profile
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'];

    // Update the user data in the database
    $stmt_update = $conn->prepare("UPDATE user_data SET first_name = ?, last_name = ?, email = ?, gender = ? WHERE userId = ?");
    $stmt_update->bind_param("ssssi", $first_name, $last_name, $email, $gender, $userId);

    if ($stmt_update->execute()) {
        // Update the session variable with the new username
        $_SESSION['username'] = $first_name . ' ' . $last_name; 

        header('Location: profile_cust.php'); 
        exit();
    } else {
        echo "<p class='error'>Error updating profile. Please try again.</p>";
    }

    $stmt_update->close();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Second Chance - Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .success {
            color: green;
            text-align: center;
        }

        .error {
            color: red;
            text-align: center;
        }

        .profile-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
                        <a href="profile_cust.php" class="flex items-center space-x-2 text-gray-700 p-2">
                            <i class="fas fa-th-large"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="order_history.php" class="flex items-center space-x- 2 text-gray-700 p-2">
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
                        <a href="settings.php" class="flex items-center space-x-2 text-gray-700 p-2">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php" class="flex items-center space-x-2 text-gray-700 p-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Log-out</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <section class="w-3/4 flex space-x-8">
            <div class="profile-form w-full">
                <h2 class="text-2xl font-semibold mb-4">Edit Profile</h2>
                <form method="POST" action="">
                    <div class="mb-4">
                        <label for="first_name" class="block text-gray-700">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" class="border border-gray-300 rounded-lg p-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label for="last_name" class="block text-gray-700">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" class="border border-gray-300 rounded-lg p-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="border border-gray-300 rounded-lg p-2 w-full" required>
                    </div>
                    <div class="mb-4">
                    <label for="gender" class="block text-gray-700">Gender</label>
                    <select id="gender" name="gender" class="border border-gray-300 rounded-lg p-2 w-full">
                        <option value="Laki-laki" <?php echo ($user['gender'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="Perempuan" <?php echo ($user['gender'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>
                    <button type="submit" class="btn">Update Profile</button>
                    <a href="profile_cust.php" class="btn" style="background-color: #e0e0e0; color: black;">Cancel</a>
                </form>
            </div>
        </section>
    </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>