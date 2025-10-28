<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Chance</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="style_catalog.css"> 
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <div class="sidebar">
            <h3>Sort by Price</h3>
            <!-- Form for selecting price order -->
            <form method="GET" action="">
                <label><input type="radio" name="sort_price" value="asc" <?php echo (isset($_GET['sort_price']) && $_GET['sort_price'] == 'asc') ? 'checked' : ''; ?> /> Lowest - Highest Price</label>
                <label><input type="radio" name="sort_price" value="desc" <?php echo (isset($_GET['sort_price']) && $_GET['sort_price'] == 'desc') ? 'checked' : ''; ?> /> Highest - Lowest Price</label>
                <button type="submit">Sort</button>
            </form>

            <h3>Term of Use</h3>
            <label><input type="checkbox"/> Brand New</label>
            <label><input type="checkbox"/> Like New</label>
            <label><input type="checkbox"/> Lightly Used</label>
            <label><input type="checkbox"/> Often Used</label>
            <label><input type="checkbox"/> Old Stuff</label>
        </div>

        <div class="products">
            <h2>Footwear Products</h2>

            <!-- Search Form -->
            <form method="POST" action="">
                <input type="text" name="search" placeholder="Search by name, category, seller, or store" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
                <button type="submit">Search</button>
            </form>

            <div class="product-grid">
                <?php
                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'sc_db');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Sort order handling
                $sort_order = '';
                if (isset($_GET['sort_price'])) {
                    if ($_GET['sort_price'] == 'asc') {
                        $sort_order = 'ORDER BY productPrice ASC';
                    } elseif ($_GET['sort_price'] == 'desc') {
                        $sort_order = 'ORDER BY productPrice DESC';
                    }
                }

                // Search functionality
                $search = isset($_POST['search']) ? $_POST['search'] : '';
                $searchTerm = '%' . $search . '%';

                // Query to fetch products from the 'product' table based on category 'Footwear' and sorting
                $sql = "SELECT * FROM product WHERE productCategory = 'Footwear' AND (productName LIKE ? OR productDesc LIKE ?) $sort_order";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $searchTerm, $searchTerm);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Loop through the products and display each one
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="product-item">';
                        echo '<img alt="' . htmlspecialchars($row['productName']) . '" src="images/' . htmlspecialchars($row['productPhoto']) . '" />';
                        echo '<h3>' . htmlspecialchars($row['productName']) . '</h3>';
                        echo '<p class="price">Rp ' . number_format($row['productPrice'], 0, ',', '.') . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No products found.</p>";
                }

                // Close the statement and connection
                $stmt->close();
                $conn->close();
                ?>
            </div>
        </div>
    </div>

</body>
</html>