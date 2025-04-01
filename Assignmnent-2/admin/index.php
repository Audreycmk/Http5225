<?php 
// Include necessary functions and header files
include '../includes/functions.php';
include '../includes/header.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user is not authenticated
if (!isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

// Restrict access to only admin users
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
?>

<div class="container mt-3">
    <!-- Section for displaying various statistics -->
    <div class="row mt-4">
        <!-- Registered Users Card -->
        <div class="col-lg-3 mb-3">
            <div class="card bg-light">
                <div class="card-header">Registered Users</div>
                <div class="card-body">
                    <p class="card-text">No. total Users: <?php echo get_user_count();?></p> 
                    <a class="btn btn-primary" href="registerd_users.php">View Registered Users</a>
                </div>
            </div>
        </div>

        <!-- Registered Admins Card -->
        <div class="col-lg-3 mb-3">
            <div class="card bg-light">
                <div class="card-header">Admins</div>
                <div class="card-body">
                    <p class="card-text">No. total Admins: <?php echo get_admin_count();?></p>
                    <a class="btn btn-primary" href="admins.php">View All Admins</a> 
                </div>
            </div>
        </div>

        <!-- Total Books Card -->
        <div class="col-lg-3 mb-3">
            <div class="card bg-light">
                <div class="card-header">Total Books</div>
                <div class="card-body">
                    <p class="card-text">No. of books available: <?php echo get_book_count();?></p> 
                    <a class="btn btn-primary" href="all_books.php" >View All Books</a> 
                </div>
            </div>
        </div>
    </div>
    
</div>

<?php
// Include footer
include '../includes/footer.php';
?>
