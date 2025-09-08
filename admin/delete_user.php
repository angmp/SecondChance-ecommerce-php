<?php
session_start();
include 'db_connect.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $userId = intval($_POST['id']);
    
    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM user_data WHERE userId = ?");
    $stmt->bind_param("i", $userId);
    
    if ($stmt->execute()) {
        // Set a success message
        $_SESSION['message'] = 'User  deleted successfully.';
    } else {
        // Set an error message
        $_SESSION['error'] = 'Error deleting user.';
    }
    
    $stmt->close();
}

// Close the database connection
$conn->close();

// Redirect back to manage_users.php
header("Location: manage_users.php");
exit();
?>