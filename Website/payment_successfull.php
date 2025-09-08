<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Transaction Successful</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&amp;display=swap" rel="stylesheet"/>

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      background-color: #fff;
    }

    .content {
      text-align: center;
      padding: 50px 20px;
    }

    .content h1 {
      color: #3cb3b3;
      font-size: 2em;
    }

    .content .transaction-box {
      border: 1px solid #e0e0e0;
      border-radius: 10px;
      padding: 50px;
      width: 500px;   
      height: 150px;
      display: inline-block;
      margin: 20px 0;
    }

    .content .transaction-box i {
      font-size: 5em;
      color: #3cb3b3;
    }

    .content p {
      color: #3cb3b3;
      font-size: 1.5em;
    }
    
    .content .back-button {
      padding: 15px 30px;
      background-color: #3cb3b3;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      display: inline-block;
      margin-top: 20px;
    }
  </style>

</head>
<body>

<?php include('header.php'); ?>

  <div class="content">
    <h1>Thank You For Your Order</h1>
    <div class="transaction-box">
      <i class="fas fa-check-circle"></i>
      <p>Transaction Successful</p>
    </div>
    <a class="back-button" href="homepage.php">Back To Homepage</a>
  </div>

<?php include('footer.php'); ?>

</body>
</html>
