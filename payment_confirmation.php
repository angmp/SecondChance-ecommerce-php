<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Chance - Confirmation</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        nav {
            display: flex;
            justify-content: center;
            background-color: #fff;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }
        .search-bar {
            display: flex;
            justify-content: center;
            padding: 20px 0;
        }
        .search-bar input {
            width: 50%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px 0 0 5px;
        }
        .search-bar button {
            padding: 10px 20px;
            border: none;
            background-color: #a8e0e1;
            color: #fff;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }
        .confirmation {
            text-align: center;
            padding: 50px 0;
        }
        .confirmation h1 {
            color: #3cb3b3;
            font-size: 2em;
        }
        .confirmation form {
            display: inline-block;
            text-align: left;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 30px;
            width: 50%;
            max-width: 600px;
        }
        .confirmation form select,
        .confirmation form input,
        .confirmation form button {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .confirmation form button {
            background-color: #3cb3b3;
            color: #fff;
            cursor: pointer;
            font-size: 1em;
        }
        
        @media (max-width: 768px) {
            .search-bar input {
                width: 70%;
            }
            .confirmation form {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<?php include('header.php'); ?>
    
    <div class="confirmation">
        <h1>Confirmation</h1>
        <form action="process_confirmation.php" method="POST" enctype="multipart/form-data">
            <label for="payment-method">Select Payment Method:</label>
            <select id="payment-method" name="payment_method" required>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
            </select>
            <label for="proof-of-transfer">Upload Proof of Transfer:</label>
            <input type="file" id="proof-of-transfer" name="proof_of_transfer" accept="image/*" required>
            <button type="submit">Upload Your Transaction</button>
        </form>
    </div>

<?php include('footer.php'); ?>
   
</body>
</html>
