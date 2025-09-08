<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Second Chance
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
            font-family: 'Roboto', sans-serif;
        }
  </style>
 </head>
 <?php include 'header.php'; ?>
 <body class="bg-gray-50">
  <!-- Main Content -->
  <main class="container mx-auto px-4 py-8 flex">
   <!-- Sidebar -->
   <aside class="w-1/4">
    <div class="bg-white shadow-md rounded-lg p-4">
     <h2 class="text-lg font-semibold mb-4">
      Navigation
     </h2>
     <ul class="space-y-4">
      <li class="flex items-center space-x-2 text-teal-500">
       <i class="fas fa-th-large">
       </i>
       <span>
        Dashboard
       </span>
      </li>
      <li class="flex items-center space-x-2 text-gray-700">
       <i class="fas fa-history">
       </i>
       <span>
        Order History
       </span>
      </li>
      <li class="flex items-center space-x-2 text-gray-700">
       <i class="fas fa-heart">
       </i>
       <span>
        Wishlist
       </span>
      </li>
      <li class="flex items-center space-x-2 text-gray-700">
       <i class="fas fa-shopping-cart">
       </i>
       <span>
        Shopping Cart
       </span>
      </li>
      <li class="flex items-center space-x-2 text-gray-700">
       <i class="fas fa-cog">
       </i>
       <span>
        Settings
       </span>
      </li>
      <li class="flex items-center space-x-2 text-gray-700">
       <i class="fas fa-sign-out-alt">
       </i>
       <span>
        Log-out
       </span>
      </li>
     </ul>
    </div>
   </aside>
   <!-- Main Section -->
   <section class="w-3/4 pl-8">
    <div class="bg-white shadow-md rounded-lg p-4">
     <div class="flex space-x-4 border-b-2 border-gray-200 pb-2 mb-4">
      <a class="text-pink-500 border-b-2 border-pink-500 pb-1" href="#">
       On Delivery
      </a>
      <a class="text-teal-500 hover:text-pink-500" href="#">
       Order Completed
      </a>
      <a class="text-teal-500 hover:text-pink-500" href="#">
       Review
      </a>
      <a class="text-teal-500 hover:text-pink-500" href="#">
       Cancellation
      </a>
     </div>
     <div class="space-y-4">
      <!-- Order Item -->
      <div class="border rounded-lg p-4 flex justify-between items-center">
       <div class="flex items-center space-x-4">
        <img alt="Image of Ferrari F40 Vintage Tees" class="w-20 h-20 object-cover rounded-lg" height="100" src="https://storage.googleapis.com/a1aa/image/ZBUOsv1xQ8qiMF720tZvFOezxr4ZlQPG0dOL4W7BuPhJJt7JA.jpg" width="100"/>
        <div>
         <h3 class="font-semibold">
          Good Store
         </h3>
         <p class="text-gray-700">
          Ferrari F40 Vintage Tees
         </p>
         <p class="text-gray-500">
          Baju dengan kondisi bagus, tidak ada kerusakan pada produk
         </p>
         <p class="text-teal-500 font-semibold">
          Rp 79.000,-
         </p>
        </div>
       </div>
       <div class="space-x-2">
        <button class="bg-teal-500 text-white px-4 py-2 rounded-lg">
         Cancel Order
        </button>
        <button class="bg-teal-500 text-white px-4 py-2 rounded-lg">
         Confirm
        </button>
       </div>
      </div>
      <!-- Order Item -->
      <div class="border rounded-lg p-4 flex justify-between items-center">
       <div class="flex items-center space-x-4">
        <img alt="Image of Ferrari F40 Vintage Tees" class="w-20 h-20 object-cover rounded-lg" height="100" src="https://storage.googleapis.com/a1aa/image/ZBUOsv1xQ8qiMF720tZvFOezxr4ZlQPG0dOL4W7BuPhJJt7JA.jpg" width="100"/>
        <div>
         <h3 class="font-semibold">
          Good Store
         </h3>
         <p class="text-gray-700">
          Ferrari F40 Vintage Tees
         </p>
         <p class="text-gray-500">
          Baju dengan kondisi bagus, tidak ada kerusakan pada produk
         </p>
         <p class="text-teal-500 font-semibold">
          Rp 79.000,-
         </p>
        </div>
       </div>
       <div class="space-x-2">
        <button class="bg-teal-500 text-white px-4 py-2 rounded-lg">
         Cancel Order
        </button>
        <button class="bg-teal-500 text-white px-4 py-2 rounded-lg">
         Confirm
        </button>
       </div>
      </div>
     </div>
    </div>
   </section>
  </main>
  <?php include 'footer.php'; ?>
 </body>
</html>
