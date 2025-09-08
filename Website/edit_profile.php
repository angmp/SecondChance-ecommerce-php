

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Second Chance</title>
    <link rel="stylesheet" href="asset/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Header Section -->
    <header class="text-center py-4">
        <img src="Second Chance.jpg" alt="E-Commerce Logo" width="200" height="100">
    </header>

    <!-- Search bar -->
    <div class="container mb-4">
        <form class="search-bar">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-secondary" type="button">Search</button>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <aside class="col-md-3">
                <nav class="nav flex-column">
                    <a class="nav-link active" href="#">Dashboard</a>
                    <a class="nav-link" href="#">Order History</a>
                    <a class="nav-link" href="#">Wishlist</a>
                    <a class="nav-link" href="#">Shopping Cart</a>
                    <a class="nav-link" href="#">Settings</a>
                    <a class="nav-link" href="#">Log-out</a>
                </nav>
            </aside>

            <!-- Profile and Billing Information -->
            <main class="col-md-9">
                <!-- Profile Card -->
                <div class="profile-card text-center mb-4">
                    <div class="profile-picture-container mb-3">
                        <img src="https://via.placeholder.com/150" alt="Profile Picture" class="profile-img" id="profile-img">
                    </div>
                    <h4>John Doe</h4>
                    <p>Customer</p>
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
                </div>

                <!-- Modal Edit Profile -->
                <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="John Doe" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="photo" class="form-label">Profile Picture</label>
                                        <input type="file" class="form-control" id="photo" name="photo">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Billing Information -->
                <div class="billing-card border p-3 mb-4">
                    <h5>Billing Address</h5>
                    <p>John Doe</p>
                    <p>123 Main Street, Anytown</p>
                    <p>johndoe@example.com</p>
                    <p>123-456-7890</p>
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editAddressModal">Edit Address</button>
                </div>

                <!-- Modal Edit Address -->
                <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editAddressModalLabel">Edit Address</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="123 Main Street, Anytown" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="johndoe@example.com" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="123-456-7890" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <?php
        include 'footer.php';
?>
</body>
</html>
