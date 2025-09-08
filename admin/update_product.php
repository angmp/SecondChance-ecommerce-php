<?php
session_start();
include 'db_connect.php'; // Include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the product ID and other details from the form
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $productDesc = $_POST['productDesc'];
    $productCategory = $_POST['productCategory'];
    $productPrice = $_POST['productPrice'];
    $productQuantity = $_POST['productQuantity'];

    // Handle file upload if a new image is provided
    $productPhoto = null;
    if (isset($_FILES['productPhoto']) && $_FILES['productPhoto']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "wddproject\uploads"; 
        $productPhoto = basename($_FILES['productPhoto']['name']);
        $targetFilePath = $targetDir . $productPhoto;

        // Move the uploaded file to the target directory
        if (!move_uploaded_file($_FILES['productPhoto']['tmp_name'], $targetFilePath)) {
            $_SESSION['error'] = "Error uploading the image.";
            header("Location: manage_products.php");
            exit();
        }
    }

    // Prepare the SQL update statement
    $sql = "UPDATE product SET productName = ?, productDesc = ?, productCategory = ?, productPrice = ?, productQuantity = ?" . ($productPhoto ? ", productPhoto = ?" : "") . " WHERE productId = ?";
    
    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    
    if ($productPhoto) {
        $stmt->bind_param("sssdii", $productName, $productDesc, $productCategory, $productPrice, $productQuantity, $productPhoto, $productId);
    } else {
        $stmt->bind_param("sssdii", $productName, $productDesc, $productCategory, $productPrice, $productQuantity, $productId);
    }

    if ($stmt->execute()) {
        $_SESSION['message'] = "Product updated successfully.";
    } else {
        $_SESSION['error'] = "Error updating product: " . $stmt->error;
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
?>