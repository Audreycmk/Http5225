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

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if request method is GET and 'id' parameter is set
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $admin_id = intval($_GET['id']); 

    // Prevent deleting the last remaining admin
    $check_query = "SELECT COUNT(*) FROM admins";
    $result = mysqli_query($conn, $check_query);
    $row = mysqli_fetch_array($result);

    if ($row[0] <= 1) {
        $_SESSION['error'] = "Cannot delete the last admin.";
        header("Location: admins.php");
        exit();
    }

    // Proceed with deletion of admin user
    $query = "DELETE FROM admins WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $admin_id);
    $success = mysqli_stmt_execute($stmt);

    // Set session message and redirect
    $_SESSION['success'] = $success ? "Admin deleted successfully!" : "Error deleting admin.";
    header("Location: admins.php");
    exit();
}
?>
