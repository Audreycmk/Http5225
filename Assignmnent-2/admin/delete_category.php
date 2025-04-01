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

// Check if request method is GET and category ID is provided
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $cat_id = intval($_GET['id']); 

    // Check if category is linked to any books
    $check_query = "SELECT COUNT(*) FROM books WHERE cat_id = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "i", $cat_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $book_count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Prevent deletion if category is in use
    if ($book_count > 0) {
        $_SESSION['error'] = "Cannot delete category. It is assigned to one or more books.";
        header("Location: all_categories.php");
        exit();
    }

    // Proceed with deletion if not linked to books
    $query = "DELETE FROM category WHERE cat_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cat_id);
    $success = mysqli_stmt_execute($stmt);

    // Set session message and redirect
    $_SESSION['success'] = $success ? "Category deleted successfully!" : "Error deleting category.";
    header("Location: all_categories.php");
    exit();
} else {
    // Redirect if no category ID is provided
    header("Location: all_categories.php");
    exit();
}
?>
