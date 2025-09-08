<?php
session_start();
include 'db_connect.php'; // Include the database connection

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

// Base SQL query
$sql = "SELECT u.*, s.phoneNumber, s.city FROM user_data u JOIN shop s ON u.userId = s.userId WHERE u.is_seller = 1";

// Prepare an array to hold the conditions
$conditions = [];
$params = [];

// Add conditions based on user input
if (!empty($search)) {
    $conditions[] = "(u.first_name LIKE ? OR u.last_name LIKE ? OR s.phoneNumber LIKE ? OR s.city LIKE ? OR u.gender LIKE ?)";
    $params[] = '%' . $search . '%';
    $params[] = '%' . $search . '%';
    $params[] = '%' . $search . '%';
    $params[] = '%' . $search . '%';
    $params[] = '%' . $search . '%';
}

// Combine conditions into the SQL query
if (count($conditions) > 0) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

// Prepare the statement
$stmt = $conn->prepare($sql);

// Dynamically bind parameters
if ($params) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}

$stmt->execute();
$sellers = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Manage Sellers</title>
    <script>
        function editSeller(userId, firstName, lastName, phone, city, gender) {
            document.getElementById('userId').value = userId;
            document.getElementById('firstName').value = firstName;
            document.getElementById('lastName').value = lastName;
            document.getElementById('phone').value = phone;
            document.getElementById('address').value = city; 
            document.getElementById('gender').value = gender;
            document.getElementById('editForm').style.display = 'block'; 
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <h1>Manage Sellers</h1>
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
            <h2>All Sellers</h2>
            <form method="POST" action="">
                <input type="text" name="search" placeholder="Search by name, phone, city, or gender" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>City</th> 
                        <th>Gender</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($seller = $sellers->fetch_assoc()): ?>                     <tr>
                        <td><?php echo htmlspecialchars($seller['first_name'] . ' ' . $seller['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($seller['phoneNumber']); ?></td> 
                        <td><?php echo htmlspecialchars($seller['city'] ?? '-'); ?></td> 
                        <td><?php echo htmlspecialchars($seller['gender']); ?></td>
                        <td><?php echo htmlspecialchars($seller['created_at']); ?></td>
                        <td>
                            <button onclick="editSeller(<?php echo $seller['userId']; ?>, '<?php echo addslashes($seller['first_name']); ?>', '<?php echo addslashes($seller['last_name']); ?>', '<?php echo addslashes($seller['phoneNumber']); ?>', '<?php echo addslashes($seller['city'] ?? ''); ?>', '<?php echo addslashes($seller['gender']); ?>')" class="action-button">Edit</button>
                            <button onclick="window.location.href='delete_seller.php?id=<?php echo $seller['userId']; ?>'; return confirm('Are you sure you want to delete this seller?');" class="action-button">Delete</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Edit Seller Form -->
            <div id="editForm" style="display: none;">
                <h3>Edit Seller</h3>
                <form action="update_seller.php" method="POST">
                    <input type="hidden" name="userId" id="userId">
                    <label for="firstName">First Name:</label>
                    <input type="text" name="firstName" id="firstName" required>
                    <label for="lastName">Last Name:</label>
                    <input type="text" name="lastName" id="lastName" required>
                    <label for="phone">Phone Number:</label>
                    <input type="text" name="phone" id="phone" required>
                    <label for="address">City:</label> 
                    <input type="text" name="address" id="address" required> 
                    <label for="gender">Gender:</label>
                    <select name="gender" id="gender" required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                        <option value="Other">Other</option>
                    </select>
                    <button type="submit">Update Seller</button>
                    <button type="button" onclick="document.getElementById('editForm').style.display='none';">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<footer>
    <p>&copy; 2024 Second Chance</p>
</footer>
</div>