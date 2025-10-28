<?php
session_start();
// Include database connection
include 'db_connect.php'; // Ensure the database connection is correct

// PHP to handle user registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    // Check if the email already exists
    $stmt_check = $conn->prepare("SELECT * FROM user_data WHERE LOWER(email) = LOWER(?)");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<p class='error'>Email sudah terdaftar. Silakan gunakan email lain.</p>";
    } else {
        // Encrypt the password before saving
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // SQL to insert user data into the table
        $stmt = $conn->prepare("INSERT INTO user_data (first_name, last_name, email, gender, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $gender, $hashed_password);

        if ($stmt->execute()) {
            // Redirect to the login page after successful registration
            header("Location: user_login.php");
            exit(); // Ensure no further code is executed after the redirect
        } else {
            echo "<p class='error'>Terjadi kesalahan, coba lagi.</p>";
        }

        $stmt->close();
    }

    $stmt_check->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengguna</title>
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
</head>
<body>
    <!-- Registration Form -->
    <div class="container">
        <div class="form-container">
            <h2>Registrasi</h2>
            <form action="" method="POST">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Daftar</button>
            </form>
            <p>Sudah memiliki akun? <a href="user_login.php">Login di sini</a></p>
        </div>
    </div>
</body>
</html>