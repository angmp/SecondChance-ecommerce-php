<?php
session_start();
ob_start(); // Buffer output to prevent header issues

include 'db_connect.php'; // Database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to handle login
function handleLogin($conn) {
    // Process login if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];  // Get email from form
        $password = $_POST['password'];  // Get password from form

        // Query to find user by email
        $stmt = $conn->prepare("SELECT * FROM user_data WHERE LOWER(email) = LOWER(?)");
        $stmt->bind_param("s", $email); // Bind email parameter
        $stmt->execute();
        $result = $stmt->get_result(); // Get query result

        if ($result->num_rows > 0) {
            // If user found, check password
            $user = $result->fetch_assoc();
            
            // Verify encrypted password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['username'] = htmlspecialchars($user['first_name'] . " " . $user['last_name']);
                $_SESSION['userId'] = $user['userId'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['is_seller'] = $user['is_seller'];

                // Check if the user is an admin (case insensitive)
                if (strtolower($user['role']) === 'admin') {
                    header("Location: /SecondChance/admin/index_admin.php");
                    exit();
                }

                // If user is a seller, get shopId and set in session
                if ($user['is_seller'] == 1) {
                    $stmt_shop = $conn->prepare("SELECT shopId FROM shop WHERE userId = ?");
                    $stmt_shop->bind_param("i", $user['userId']);
                    $stmt_shop->execute();
                    $result_shop = $stmt_shop->get_result();
                    
                    if ($result_shop->num_rows > 0) {
                        $shop = $result_shop->fetch_assoc();
                        $_SESSION['shopId'] = $shop['shopId'];
                    } else {
                        echo "<p class='error'>Shop ID not found for this user.</p>";
                        exit();
                    }
                    
                    $stmt_shop->close();
                }

                // Set cookie for automatic login for 10 minutes
                setcookie("userId", $user['userId'], time() + (10 * 60), "/");

                // Insert login activity into user_login table
                $login_time = date("Y-m-d H:i:s");
                $stmt_insert = $conn->prepare("INSERT INTO user_login (userId, email, login_time) VALUES (?, ?, ?)");
                $stmt_insert->bind_param("iss", $user['userId'], $email, $login_time);

                if ($stmt_insert->execute()) {
                    // Redirect based on user role
                    if ($user['is_seller'] == 1) {
                        header("Location: seller_dashboard.php");
                    } else {
                        header("Location: homepage2.php");
                    }
                    exit();
                } else {
                    echo "<p class='error'>Failed to log login activity: " . $stmt_insert->error . "</p>";
                }

                $stmt_insert->close();
            } else {
                echo "<p class='error'>Incorrect password.</p>";
            }
        } else {
            echo "<p class='error'>Email not found.</p>";
        }

        $stmt->close(); // Close statement
    }
}

// Call the login handler
handleLogin($conn);
$conn->close(); // Close database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Second Chance</title>
    
<style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 500px;
            width: 100%;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            border-top: 5px solid #24888b;
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: #24888b;
            text-align: center;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        form input, form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        form input:focus, form select:focus {
            border-color: #24888b;
            outline: none;
            box-shadow: 0 0 4px rgba(36, 136, 139, 0.5);
        }

        button {
            background-color: #ff69b4;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            width: 100%;
            background-color: #24888b;
        }

        button:hover {
            background-color: #d95f99;
        }

        .success {
            color: #24888b;
            margin-bottom: 20px;
            text-align: center;
        }

        .error {
            color: #ff69b4;
            margin-bottom: 20px;
            text-align: center;
        }

        p {
            font-size: 14 ```html
            px;
            text-align: center;
        }

        p a {
            color: #24888b;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }
        </style>
<body>

    <div class="container">
        <div class="form-container">
            <h2>Login</h2>
            <form action="" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
            </form>
            <p class="register-link">Don't have an account? <a href="user_register.php">Register here</a></p>
        </div>
    </div>

</body>
</html>