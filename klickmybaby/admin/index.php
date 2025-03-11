<?php
session_start();
require_once '../includes/db_connect.php';

// Define ADMIN_ACCESS constant for included files
define('ADMIN_ACCESS', true);

// Simple authentication
$admin_username = "admin";
$admin_password = "admin123"; // In a real application, use password_hash

// Check if user is logged in
$is_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = isset($_POST['username']) ? sanitize_input($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        $is_logged_in = true;
    } else {
        $login_error = "Invalid username or password";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KLICKMYBABY Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 20px;
        }
        .container {
            max-width: 1200px;
        }
        .nav-tabs {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">KLICKMYBABY Admin Panel</h1>
        
        <?php if (!$is_logged_in): ?>
            <!-- Login Form -->
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header">
                            Admin Login
                        </div>
                        <div class="card-body">
                            <?php if (isset($login_error)): ?>
                                <div class="alert alert-danger"><?php echo $login_error; ?></div>
                            <?php endif; ?>
                            
                            <form method="post" action="">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" name="login" class="btn btn-primary">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Admin Dashboard -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Welcome, Admin</h2>
                <a href="?logout=1" class="btn btn-danger">Logout</a>
            </div>
            
            <ul class="nav nav-tabs" id="adminTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="true">Reviews</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bookings-tab" data-bs-toggle="tab" data-bs-target="#bookings" type="button" role="tab" aria-controls="bookings" aria-selected="false">Bookings</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">Contact Messages</button>
                </li>
            </ul>
            
            <div class="tab-content" id="adminTabsContent">
                <!-- Reviews Tab -->
                <div class="tab-pane fade show active" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <?php include 'reviews.php'; ?>
                </div>
                
                <!-- Bookings Tab -->
                <div class="tab-pane fade" id="bookings" role="tabpanel" aria-labelledby="bookings-tab">
                    <?php include 'bookings.php'; ?>
                </div>
                
                <!-- Contacts Tab -->
                <div class="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                    <?php include 'contacts.php'; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>