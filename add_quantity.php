<?php
session_start();

if (isset($_GET['id']) && isset($_GET['quantity'])) {
    $id = $_GET['id'];
    $quantity = $_GET['quantity'];
    
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $id) {
            $item['quantity'] = $quantity;
            break;
        }
    }
}

header("Location: cart.php");
exit();
?>