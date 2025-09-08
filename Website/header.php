<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Chance - Confirmation</title>
    <!-- External Stylesheets -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Internal Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            text-align: center;
            padding: 20px 0;
            background-color: #fff;
        }

        header img {
            width: 150px;
        }

        .icon-bar {
            display: flex;
            justify-content: center; 
            align-items: center; 
            padding: 10px 0;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            position: relative; 
        }

        .icon-bar a {
            margin: 0 15px;
            color: #45B4B1;
            font-size: 1.5em; 
            text-decoration: none;
        }

        .greeting {
            position: absolute; 
            right: 10px; 
            color: #45B4B1; 
            font-weight: 700; 
            padding-left: 10px; 
        }

        nav {
            display: flex;
            justify-content: center; 
            background-color: #fff;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #45B4B1; 
            font-weight: 500;
        }

        nav a:hover {
            color: #FF69B4; 
        }

        .nav-link.active {
            color: #FF69B4;
        }

        .search-bar {
            display: flex;
            justify-content: center;
            padding: 20px 0;
            border-bottom: 1px solid #ddd;
        }

        .search-bar input {
            width: 50%;
            padding: 10px;
            background-color: #CAF2F1;
            border: 1px solid #ddd;
            border-radius: 5px 0 0 5px;
        }

        .search-bar button {
            padding: 10px 20px;
            border: none;
            background-color: #45B4B1;
            color: #fff;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .search-bar input {
                width: 70%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <a href="index.php">
            <img src="uploads/Second Chance.jpg" alt="Second Chance Logo">
        </a>
    </header>

    <!-- Icon Bar -->
    <div class="icon-bar">
        <a href="homepage2.php" title="Home"><i class="fas fa-home"></i></a>
        <a href="<?php echo isset($_SESSION['username']) ? 'profile_cust.php' : 'user_login.php'; ?>" title="Profile"><i class="fas fa-user"></i></a>
        <a href="<?php echo isset($_SESSION['username']) ? 'cart.php' : 'user_login.php'; ?>" title="Cart"><i class="fas fa-shopping-cart"></i></a>

        <div class="greeting">
            <a href="<?php echo isset($_SESSION['username']) ? 'profile_cust.php' : 'user_login.php'; ?>" style="color: #45B4B1; text-decoration: none;">
                <?php 
                    if (isset($_SESSION['username'])) {
                        echo "Happy Shopping, " . htmlspecialchars($_SESSION['username']) . "!";
                    } else {
                        echo "Hi bestie, log in here!";
                    }
                ?>
                            </div>
        </div>

        <!-- Navigation -->
        <nav>
            <a href="listing_shirts.php" class="nav-link" id="shirts-link">Shirts</a>
            <a href="listing_sweaters-hoodies.php" class="nav-link" id="sweaters-link">Sweaters & Hoodies</a>
            <a href="listing_pants-jeans.php" class="nav-link" id="pants-link">Pants & Jeans</a>
            <a href="listing_accessories.php" class="nav-link" id="accessories-link">Accessories</a>
            <a href="listing_footwear.php" class="nav-link" id="footwear-link">Footwear</a>
        </nav>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" placeholder="Cari produk...">
            <button>Cari</button>
        </div>

        <script>
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    link.style.color = '#FF69B4';
                    link.classList.add('active');
                });
            });
        </script>
    </body>
</html>
           