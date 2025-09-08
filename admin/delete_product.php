<?php
session_start();
include 'db_connect.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the product ID from the form
    $productId = $_POST['id'];

    // Prepare the SQL delete statement
    $sql = "DELETE FROM product WHERE productId = ?";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $productId);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Product deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting product: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to manage products page
    header("Location: manage_products.php");
    exit();
} else {
    // If the request method is not POST, redirect to manage products
    header("Location: manage_products.php");
    exit();
}