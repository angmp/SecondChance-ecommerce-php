<?php
session_start();
include 'db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    
    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM user_data WHERE userId = ?");
    $stmt->bind_param("i", $userId);
    
    if ($stmt->execute()) {
        // Set a success message
        $_SESSION['message'] = 'Seller deleted successfully.';
    } else {
        // Set an error message
        $_SESSION['error'] = 'Error deleting seller.';
    }
    
    $stmt->close();
}

// Close the database connection
$conn->close();

// Redirect back to manage_sellers.php
header("Location: manage_sellers.php");
exit();
?>