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

// Initialize search variable
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Fetch all users from the database with search functionality
$users = $conn->query("SELECT * FROM user_data WHERE role = 'Customer' AND (first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR phone LIKE '%$search%' OR address LIKE '%$search%' OR gender LIKE '%$search%')");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Manage Users</title>
    <script>
        function editUser (userId, firstName, lastName, phone, address, gender, birthDate) {
            document.getElementById('userId').value = userId;
            document.getElementById('firstName').value = firstName;
            document.getElementById('lastName').value = lastName;
            document.getElementById('phone').value = phone;
            document.getElementById('address').value = address;
            document.getElementById('gender').value = gender;
            document.getElementById('birthDate').value = birthDate;
            document.getElementById('editModal').style.display = 'block'; 
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none'; 
        }
    </script>
    <style>
        /* Modal styles */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <h1>Manage Users</h1>
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
            <h2>All Users</h2>

            <!-- Search Form -->
            <form method="POST" action="">
                <input type="text" name="search" placeholder="Search by name, phone, address, or gender" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Birthdate</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                        <td><?php echo htmlspecialchars($user['address'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($user['gender']); ?></td>
                        <td><?php echo htmlspecialchars($user['birth_date'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                        <td>
                            <button onclick="editUser (<?php echo $user['userId']; ?>, '<?php echo addslashes($user['first_name']); ?>', '<?php echo addslashes($user['last_name']); ?>', '<?php echo addslashes($user['phone']); ?>', '<?php echo addslashes($user['address'] ?? ''); ?>', '<?php echo addslashes($user['gender']); ?>', '<?php echo addslashes($user['birth_date'] ?? ''); ?>')">Edit</button>
                            <form action="delete_user.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $user['userId']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Edit User Modal -->
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h3>Edit User</h3>
                    <form action="update_user.php" method="POST">
                        <input type="hidden" name="userId" id="userId">
                        <label for="firstName">First Name:</label>
                        <input type="text" name="firstName" id="firstName" required>
                        <label for="lastName">Last Name:</label>
                        <input type="text" name="lastName" id="lastName" required>
                        <label for="phone">Phone Number:</label>
                        <input type="text" name="phone" id="phone" required>
                        <label for="address">Address:</label>
                        <input type="text" name="address" id="address">
                        <label for="gender">Gender:</label>
                        <select name="gender" id="gender" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                            <option value="Other">Other</option>
                        </select>
                        <label for="birthDate">Birthdate:</label>
                        <input type="date" name="birthDate" id="birthDate" required>
                        <button type="submit">Update User</button>
                        <button type="button" onclick="closeModal()">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<footer>
    <p>&copy; 2024 Second Chance</p>
</footer>