<?php
session_start();
ob_start(); // Buffer output untuk mencegah masalah header

include 'db_connect.php'; // Koneksi database

// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Proses login jika form dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];  // Mengambil email dari form
    $password = $_POST['password'];  // Mengambil password dari form

    // Query untuk mencari pengguna berdasarkan email
    $stmt = $conn->prepare("SELECT * FROM user_data WHERE LOWER(email) = LOWER(?)");
    $stmt->bind_param("s", $email); // Mengikat parameter email
    $stmt->execute();
    $result = $stmt->get_result(); // Mengambil hasil query

    if ($result->num_rows > 0) {
        // Jika ada pengguna yang ditemukan, periksa password
        $user = $result->fetch_assoc();
        
        // Memverifikasi password yang dienkripsi
        if (password_verify($password, $user['password'])) {
            // Set session dan cookie untuk login otomatis
            $_SESSION['username'] = $user['first_name'] . " " . $user['last_name'];
            $_SESSION['userId'] = $user['userId'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['is_seller'] = $user['is_seller'];

            // Set cookie untuk login otomatis selama 10 menit
            setcookie("userId", $user['userId'], time() + (10 * 60), "/");

            // Masukkan data ke tabel user_login
            $login_time = date("Y-m-d H:i:s");
            $stmt_insert = $conn->prepare("INSERT INTO user_login (userId, email, login_time) VALUES (?, ?, ?)");
            $stmt_insert->bind_param("iss", $user['userId'], $email, $login_time);

            if ($stmt_insert->execute()) {
                // Redirect berdasarkan peran pengguna
                if ($user['role'] === 'Admin') {
                    header("Location: admin_dashboard.php");
                } elseif ($user['role'] === 'Customer' && $user['is_seller'] == 1) {
                    header("Location: seller_page.php");
                } elseif ($user['role'] === 'Customer' && $user['is_seller'] == 0) {
                    header("Location: homepage2.php");
                }
                exit();
            } else {
                echo "<p class='error'>Gagal mencatat aktivitas login: " . $stmt_insert->error . "</p>";
            }

            $stmt_insert->close();
        } else {
            echo "<p class='error'>Password salah.</p>";
        }
    } else {
        echo "<p class='error'>Email tidak ditemukan.</p>";
    }

    $stmt->close(); // Menutup statement
    $conn->close(); // Menutup koneksi database
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Second Chance</title>
   
</head>
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
            <p class="register-link">Don't have an account? <a href="seller_registrasi.php">Register here</a></p>
        </div>
    </div>

</body>
</html>