<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['userId']) || empty($_SESSION['userId'])) {
    die("You must be logged in to proceed with the checkout.");
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sc_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if items are selected for checkout
if (isset($_POST['selectedProducts'])) {
    $selectedItems = $_POST['selectedProducts'];
    $userId = $_SESSION['userId'];

    // Calculate total transaction amount and gather data for selected items
    $totalAmount = 0;
    $cartItems = [];

    // Prepare SQL query to fetch selected cart items
    $placeholders = implode(',', array_fill(0, count($selectedItems), '?'));
    $sql = "SELECT c.cartId, c.productId, p.productName, c.quantity, p.productPrice 
            FROM cart c
            JOIN product p ON c.productId = p.productId
            WHERE c.userId = ? AND c.cartId IN ($placeholders)";
    $stmt = $conn->prepare($sql);

    // Bind parameters for the query
    $bindValues = array_merge([$userId], $selectedItems);
    $types = 'i' . str_repeat('i', count($selectedItems));
    $stmt->bind_param($types, ...$bindValues);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
        $totalAmount += $row['productPrice'] * $row['quantity'];
    }

    if (count($cartItems) > 0) {
        // Start transaction
        $conn->begin_transaction();

        try {
            // Insert into transactions table
            $insertTransactionSql = "INSERT INTO transactions (userId, totalAmount, status) VALUES (?, ?, 'Pending')";
            $stmt = $conn->prepare($insertTransactionSql);
            $stmt->bind_param("id", $userId, $totalAmount);
            $stmt->execute();
            $transactionId = $conn->insert_id;

            // Insert into transactions_detail table
            $insertDetailSql = "INSERT INTO transactions_detail (transactionId, productId, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertDetailSql);

            foreach ($cartItems as $item) {
                $stmt->bind_param("iiid", $transactionId, $item['productId'], $item['quantity'], $item['productPrice']);
                $stmt->execute();
            }

            // Commit transaction if successful
            $conn->commit();

            // Delete items from the cart after successful checkout
            $deleteCartSql = "DELETE FROM cart WHERE userId = ? AND cartId IN ($placeholders)";
            $stmt = $conn->prepare($deleteCartSql);
            $stmt->bind_param($types, ...$bindValues);
            $stmt->execute();

            echo "Checkout successful. Your transaction ID is: " . $transactionId;
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "No items found for the selected checkout.";
    }
} else {
    echo "No items selected for checkout.";
}

$conn->close();
?>
