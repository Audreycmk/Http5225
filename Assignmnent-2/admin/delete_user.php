<?php
// Include database connection and utility functions
require '../includes/conn.php';
require '../includes/functions.php';

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

// Check if request method is GET and user ID is provided
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // Prepare DELETE query to remove user
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    // Execute the query and store success message
    $success = mysqli_stmt_execute($stmt);
    $_SESSION['success'] = $success ? "User deleted successfully!" : "Error deleting user.";
}

// Redirect to the registered users page
header("Location: registerd_users.php");
exit();
?>
