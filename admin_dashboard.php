
<?php
session_start();

// Koneksi database
try {
    $conn = new PDO("mysql:host=localhost;dbname=sc_db", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['userId'])) {
    header("Location: user_login.php");
    exit();
}

// Ambil data pengguna berdasarkan userId di session
$stmt = $conn->prepare("SELECT role, is_seller, first_name FROM user_data WHERE userId = ?");
$stmt->bindParam(1, $_SESSION['userId']);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    // Data pengguna tidak ditemukan, redirect ke login
    header("Location: user_login.php");
    exit();
}

// Simpan nama depan untuk ditampilkan di halaman
$firstName = htmlspecialchars($userData['first_name']);

// Periksa peran pengguna
if ($userData['role'] == 'Admin') {
    // Pengguna adalah admin, lanjutkan ke dashboard admin
} elseif ($userData['role'] == 'User') {
    if ($userData['is_seller'] == 1) {
        // Pengguna adalah penjual, redirect ke halaman penjual
        header("Location: seller_dashboard.php");
        exit();
    } elseif ($userData['is_seller'] == 0) {
        // Pengguna adalah pembeli, redirect ke halaman pembeli
        header("Location: buyer_dashboard.php");
        exit();
    }
} else {
    // Peran tidak valid, redirect ke login
    header("Location: user_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style_dash.css">
    <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

    <style>
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background: #333;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1100;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            font-size: 1.2rem;
            margin: 0;
            color: #;
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .main-menu {
            width: 250px;
            height: 100vh;
            background: #333;
            position: fixed;
            top: 0;
            left: -250px; 
            transition: left 0.3s ease-in-out;
            z-index: 1000;
        }

        .main-menu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .main-menu ul li {
            margin: 10px 0;
        }

        .main-menu ul li a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 15px;
            transition: background 0.3s ease;
        }

        .main-menu ul li a:hover {
            background: #444;
        }

        .main-menu.active {
            left: 0;
        }

        #hamburger {
            position: fixed;
            top: 15px; 
            left: 15px; 
            width: 40px;
            height: 40px;
            cursor: pointer;
            z-index: 1100; 
            transition: transform 0.3s ease;
        }

        #hamburger g path {
            stroke: #fff;
        }

        /* Content */
        .content {
            margin-left: 0;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        .content.active {
            margin-left: 250px; 
        }

        /* Content Styles */
        .content {
            margin-left: 0; 
            padding: 20px;
            transition: margin-left 0.3s ease; 
        }

        .content.active {
            margin-left: 250px; 
        }

        /* Optional: Hover Effect for Hamburger */
        #hamburger:hover g path {
            stroke: #777; 
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <h1>Hi!, <?php echo $firstName; ?>!</h1>
        <!-- Tombol Hamburger -->
        <svg id="hamburger" class="Header__toggle-svg" viewBox="0 0 60 40">
            <g stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                <path id="top-line" d="M10,10 L50,10 Z"></path>
                <path id="middle-line" d="M10,20 L50,20 Z"></path>
                <path id="bottom-line" d="M10,30 L50,30 Z"></path>
            </g>
        </svg>
    </header>

    <!-- Sidebar -->
    <nav class="main-menu">
        <br>
        <ul>
            <li>
                <a href="admin_dashboard.php">
                    <i class="fa fa-home fa-lg"></i>
                    <span class="nav-text">Home</span>
                </a>
            </li>
            <li>
                <a href="control_register.php">
                    <i class="fa fa-clock-o fa-lg"></i>
                    <span class="nav-text">Control Register</span>
                </a>
            </li>
            <li>
                <a href="crud_users.php">
                    <i class="fa fa-desktop fa-lg"></i>
                    <span class="nav-text">CRUD Users</span>
                </a>
            </li>
            <li>
                <a href="post_announcement.php">
                    <i class="fa fa-plane fa-lg"></i>
                    <span class="nav-text">Post Announcement</span>
                </a>
            </li>
            <li>
                <a href="manage_marketplace.php">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="nav-text">Manage Marketplace</span>
                </a>
            </li>
        </ul>
        <ul class="logout">
            <li>
                <a href="logout.php">
                    <i class="fa fa-sign-out fa-lg"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Content Area -->
    <div class="content">
        <div class="container-fluid">
            <br>
            <h1 class="my-4">Welcome, Admin!</h1>
            <p class="lead">Here is an overview of your platform's activity and shortcuts to manage features.</p>

            <!-- Row 1: Statistics -->
            <div class="row">
                <!-- Card: Total Users -->
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-primary shadow">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text"><strong><?php echo $totalResidents; ?></strong></p>
                        </div>
                        <div class="card-footer">
                            <a href="crud_users.php" class="text-white">Manage Users <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Card: Active Sessions -->
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-success shadow">
                        <div class="card-body">
                            <h5 class="card-title">Active Sessions</h5>
                            <p class="card-text"><strong>245</strong></p>
                        </div>
                        <div class="card-footer">
                            <a href="control_register.php" class="text-white">View Activity <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Card: Announcements -->
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-info shadow">
                        <div class="card-body">
                            <h5 class="card-title">Announcements</h5>
                            <p class="card-text"><strong>3</strong></p>
                        </div>
                        <div class="card-footer">
                            <a href="post_announcement.php" class="text-white">Post Announcement <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk sidebar toggle -->
    <script>
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.querySelector('.main-menu');
        const content = document.querySelector('.content');

        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('active'); 
            content.classList.toggle('active');
        });
    </script>
    <?php
        include 'footer.php';
?>
</body>
</html>
