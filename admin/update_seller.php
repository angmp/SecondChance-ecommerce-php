<?php
session_start();
include 'db_connect.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $birthDate = $_POST['birthDate'];

    // Prepare and execute the update statement
    $stmt = $conn->prepare("UPDATE user_data SET first_name=?, last_name=?, phone=?, address=?, gender=?, birth_date=? WHERE userId=?");
    $stmt->bind_param("ssssssi", $firstName, $lastName, $phone, $address, $gender, $birthDate, $userId);

    if ($stmt->execute()) {
        $_SESSION['message'] = "User  updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating user.";
    }

    $stmt->close();
    $conn->close();

    header("Location: manage_sellers.php");
    exit();
}
?>