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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and trim input
    $cat_name = htmlspecialchars(trim($_POST['cat_name']));

    // Validate input
    if (empty($cat_name)) {
        $_SESSION['error'] = "Category name is required.";
    } else {
        // Check if category already exists
        $check_query = "SELECT cat_id FROM category WHERE cat_name = ?";
        $stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($stmt, "s", $cat_name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) { // Prevent duplicate categories
            $_SESSION['error'] = "Category already exists.";
            header("Location: all_categories.php");
            exit();
        }
        mysqli_stmt_close($stmt);

        // Insert category into the database
        $query = "INSERT INTO category (cat_name) VALUES (?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $cat_name);
        $success = mysqli_stmt_execute($stmt);

        // Set success or error message
        $_SESSION['success'] = $success ? "Category added successfully!" : "Error adding category.";
    }

    // Redirect back to categories page
    header("Location: all_categories.php");
    exit();
}
