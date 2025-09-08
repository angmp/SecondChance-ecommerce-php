<?php
session_start();
include 'db_connect.php'; // Include the database connection

// Display success or error messages
if (isset($_SESSION['message'])) {
    echo "<div class='success'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']);
}

if (isset($_SESSION['error'])) {
    echo "<div class='error'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}

// Search functionality
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Prepare SQL query
$sql = "SELECT p.productId, p.productName, p.productDesc, p.productCategory, p.productPrice, p.productQuantity, 
               ud.first_name, ud.last_name, s.shopName 
        FROM product p 
        JOIN user_data ud ON p.userId = ud.userId 
        JOIN shop s ON p.userId = s.userId 
        WHERE p.productName LIKE ? OR p.productCategory LIKE ? 
        OR ud.first_name LIKE ? OR ud.last_name LIKE ? 
        OR s.shopName LIKE ? OR p.productPrice LIKE ? OR p.productQuantity LIKE ? 
        ORDER BY p.productName ASC";

$searchTerm = '%' . $search . '%';
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssss', $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Manage Products</title>
    <script>
        function editProduct(productId, productName, productDesc, productCategory, productPrice, productQuantity) {
            document.getElementById('productId').value = productId;
            document.getElementById('productName').value = productName;
            document.getElementById('productDesc').value = productDesc;
            document.getElementById('productCategory').value = productCategory;
            document.getElementById('productPrice').value = productPrice;
            document.getElementById('productQuantity').value = productQuantity;
            document.getElementById('editForm').style.display = 'block'; // Show the edit form
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <h1>Manage Products</h1>
        </div>
        
        <div class="sidebar">
            <ul>
                <li><a href="index_admin.php">Home</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="manage_sellers.php">Manage Sellers</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="login_admin.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h2>All Products</h2>
            <form method="POST" action="">
                <input type="text" name="search" placeholder="Search by name, category, seller, or store" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Uploaded By</th>
                        <th>Store Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['productName']); ?></td>
                        <td><?php echo htmlspecialchars($product['productDesc'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($product['productCategory'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($product['productPrice']); ?></td>
                        <td><?php echo htmlspecialchars($product['productQuantity']); ?></td>
                        <td><?php echo htmlspecialchars($product['first_name'] . ' ' . $product['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($product['shopName']); ?></td>
                        <td>
                            <button onclick="window.location.href='edit_product.php?productId=<?php echo $product['productId']; ?>'">Edit</button>
                            <form action="delete_product.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $product['productId']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<footer>
    <p>&copy; 2024 Second Chance</p>
</footer>
</div>
<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
